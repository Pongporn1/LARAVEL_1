# Laravel Query Builder Examples

This project demonstrates comprehensive Laravel Query Builder usage with practical examples from a diary application.

## 🔍 Key Query Builder Concepts Implemented

### 1. Basic Operations

#### SELECT Operations
```php
// Basic select all
$diaryEntries = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->get();

// Select specific columns
$contents = DB::table('diary_entries')
    ->select('content', 'title')
    ->where('user_id', $userId)
    ->get();
```

#### pluck() vs select() - The Key Difference

**pluck() - Returns Flat Array:**
```php
$contents = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->pluck('content');

// Result: ["My first diary", "Laravel notes", "Vacation plans"]
```

**select() - Returns Objects:**
```php
$contents = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->select('content')
    ->get();

// Result: [{"content": "My first diary"}, {"content": "Laravel notes"}]
```

**pluck() with Key-Value Pairs:**
```php
$titles = DB::table('diary_entries')->pluck('title', 'id');
// Result: [1 => "My first diary", 2 => "Laravel notes"]
// Perfect for HTML select dropdowns!
```

### 2. CRUD Operations

#### INSERT
```php
DB::table('diary_entries')->insert([
    'user_id' => Auth::id(),
    'date' => now(),
    'content' => 'Today I learned Laravel Query Builder!',
    'created_at' => now(),
    'updated_at' => now(),
]);
```

#### UPDATE
```php
DB::table('diary_entries')
    ->where('id', 1)
    ->where('user_id', Auth::id())
    ->update(['content' => 'Updated content']);
```

#### DELETE
```php
DB::table('diary_entries')
    ->where('id', 1)
    ->where('user_id', Auth::id())
    ->delete();
```

### 3. Aggregate Functions

```php
// Count entries
$count = DB::table('diary_entries')->where('user_id', $userId)->count();

// Get date range
$earliest = DB::table('diary_entries')->where('user_id', $userId)->min('date');
$latest = DB::table('diary_entries')->where('user_id', $userId)->max('date');

// Average content length
$avgLength = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->avg(DB::raw('LENGTH(content)'));
```

### 4. JOIN Operations

#### Basic JOIN
```php
$entries = DB::table('diary_entries')
    ->join('users', 'diary_entries.user_id', '=', 'users.id')
    ->select('diary_entries.*', 'users.name')
    ->get();
```

#### Complex Multi-JOIN
```php
$happyCount = DB::table('users as u')
    ->join('diary_entries as de', 'u.id', '=', 'de.user_id')
    ->join('diary_entry_emotions as dee', 'de.id', '=', 'dee.diary_entry_id')
    ->where('u.id', $userId)
    ->where('dee.emotion_id', 1) // Happy emotion
    ->count('de.id');
```

### 5. Advanced Queries

#### Raw Expressions with GROUP BY and HAVING
```php
$dailyCount = DB::table('diary_entries')
    ->select('date', DB::raw('count(*) as count'))
    ->where('user_id', $userId)
    ->groupBy('date')
    ->having('count', '>=', 2)
    ->get();
```

#### HAVING BETWEEN
```php
$moderateCounts = DB::table('diary_entries')
    ->select('date', DB::raw('count(*) as count'))
    ->where('user_id', $userId)
    ->groupBy('date')
    ->havingBetween('count', [3, 4])
    ->get();
```

#### WHERE RAW with Safe Parameter Binding
```php
// ❌ UNSAFE - SQL Injection Risk
$entries = DB::table('diary_entries')
    ->whereRaw("date = '$date'")
    ->get();

// ✅ SAFE - Parameter Binding
$entries = DB::table('diary_entries')
    ->whereRaw("date BETWEEN ? AND ?", [$startDate, $endDate])
    ->get();
```

### 6. Search and Filtering

#### LIKE Search
```php
$results = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->where(function($query) use ($keyword) {
        $query->where('content', 'like', "%{$keyword}%")
              ->orWhere('title', 'like', "%{$keyword}%");
    })
    ->get();
```

#### Conditional Queries
```php
$query = DB::table('diary_entries')->where('user_id', $userId);

if ($request->has('search')) {
    $query->where('content', 'like', "%{$request->search}%");
}

if ($request->has('date_range')) {
    $query->whereBetween('date', [$startDate, $endDate]);
}

$results = $query->get();
```

### 7. Pagination and Ordering

```php
// Pagination
$entries = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->orderBy('date', 'desc')
    ->paginate(10);

// Distinct values
$uniqueDates = DB::table('diary_entries')
    ->where('user_id', $userId)
    ->distinct()
    ->pluck('date');
```

### 8. Transactions

```php
try {
    DB::beginTransaction();
    
    $entryId = DB::table('diary_entries')->insertGetId([...]);
    
    DB::table('diary_entry_emotions')->insert([...]);
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
    throw $e;
}
```

## 🚀 How to Use This Project

### 1. Access Query Builder Examples
Visit: `/query-builder` to see all examples with interactive buttons

### 2. API Endpoints
- `GET /api/query-builder/compare-pluck-select` - See pluck() vs select() difference
- `POST /api/query-builder/diary/create` - Create diary entry with Query Builder
- `GET /api/query-builder/diary/statistics` - Comprehensive statistics
- `GET /api/query-builder/diary/search` - Advanced search with filters

### 3. Run Tests
```bash
./vendor/bin/sail test tests/Feature/QueryBuilderTest.php
```

## 📊 Query Builder vs Eloquent Comparison

| Operation | Query Builder | Eloquent |
|-----------|---------------|----------|
| **Basic Select** | `DB::table('diary_entries')->where('user_id', $id)->get()` | `Auth::user()->diaryEntries()->get()` |
| **Insert** | `DB::table('diary_entries')->insert([...])` | `Auth::user()->diaryEntries()->create([...])` |
| **Update** | `DB::table('diary_entries')->where('id', 1)->update([...])` | `$entry->update([...])` |
| **Delete** | `DB::table('diary_entries')->where('id', 1)->delete()` | `$entry->delete()` |
| **Count** | `DB::table('diary_entries')->count()` | `Auth::user()->diaryEntries()->count()` |

## 🎯 Key Benefits of Query Builder

1. **Direct SQL Control** - More control over exact SQL generated
2. **Performance** - Can be more efficient for complex queries
3. **Flexibility** - Easier to build dynamic queries
4. **No Model Dependencies** - Works without Eloquent models
5. **Raw SQL Integration** - Easy to mix raw SQL when needed

## 🛡️ Security Best Practices

1. **Always use parameter binding** with `whereRaw()`:
   ```php
   // ✅ Safe
   ->whereRaw("date BETWEEN ? AND ?", [$start, $end])
   
   // ❌ Dangerous
   ->whereRaw("date BETWEEN '$start' AND '$end'")
   ```

2. **Validate input** before using in queries
3. **Use transactions** for multi-step operations
4. **Limit results** with pagination to prevent memory issues

## 📁 File Structure

```
app/Http/Controllers/
├── QueryBuilderController.php      # Main Query Builder examples
└── Api/QueryBuilderApiController.php   # API endpoints

resources/views/
├── query-builder/
│   └── index.blade.php            # Interactive examples page
└── diary/
    └── display_diary.blade.php    # Query Builder results display

routes/
├── web.php                        # Web routes for examples
└── api.php                        # API routes

tests/Feature/
└── QueryBuilderTest.php           # Comprehensive tests
```

This implementation provides a complete learning resource for Laravel Query Builder with practical examples, tests, and security best practices!