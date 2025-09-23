@csrf
<div class="space-y-5">
  <div>
    <label class="block text-sm font-medium text-slate-300">Title</label>
    <input type="text" name="title"
           value="{{ old('title', $reminder->title ?? '') }}"
           class="mt-1 w-full rounded-xl bg-slate-800 border border-slate-700 text-slate-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('title') <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-slate-300">Remind At</label>
    <input type="datetime-local" name="remind_at"
           value="{{ old('remind_at', isset($reminder->remind_at) ? \Illuminate\Support\Carbon::parse($reminder->remind_at)->format('Y-m-d\TH:i') : '') }}"
           class="mt-1 w-full rounded-xl bg-slate-800 border border-slate-700 text-slate-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('remind_at') <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium text-slate-300">Status</label>
    <input type="text" name="status"
           value="{{ old('status', $reminder->status ?? 'New') }}"
           class="mt-1 w-full rounded-xl bg-slate-800 border border-slate-700 text-slate-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>

  <div>
    <label class="block text-sm font-medium text-slate-300 mb-1">Tags</label>
    <select name="tags[]" multiple
            class="w-full min-h-[120px] rounded-xl bg-slate-800 border border-slate-700 text-slate-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      @foreach($tags as $tag)
        <option value="{{ $tag->id }}"
          @selected(collect(old('tags', isset($reminder) ? $reminder->tags->pluck('id')->all() : []))->contains($tag->id))>
          {{ $tag->name }}
        </option>
      @endforeach
    </select>
    <p class="text-xs text-slate-500 mt-1">กด Ctrl/Command เพื่อเลือกหลายอัน</p>
  </div>

  <div class="pt-2 flex items-center gap-3">
    <button class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white">Save</button>
    <a href="{{ route('reminders.index') }}"
       class="px-5 py-2 rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-100">Cancel</a>
  </div>
</div>
