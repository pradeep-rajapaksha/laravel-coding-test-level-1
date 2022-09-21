<div class="col-6 col-xs-12">
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required value="{{ $event->name ?? old('name') }}">
        @error('firstname') <div class="error text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label for="slug">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" required value="{{ $event->slug ?? old('slug') }}">
        @error('firstname') <div class="error text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label for="start-at">Start At</label>
        <input type="datetime-local" class="form-control" id="start-at" name="startAt" required value="{{ $event->startAt ?? old('startAt') }}">
        @error('firstname') <div class="error text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label for="end-at">End At</label>
        <input type="datetime-local" class="form-control" id="end-at" name="endAt" required value="{{ $event->endAt ?? old('endAt') }}">
        @error('firstname') <div class="error text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <button class="btn btn-success" type="submit">Submit</button>
    </div>
</div>