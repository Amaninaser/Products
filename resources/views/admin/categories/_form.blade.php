<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <p class="invalid-feedback"> {{ $message }} </p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Parent:</label>
    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <option value="">No Parent</option>
        @foreach ($parents as $parent)
        <option value="{{ $parent->id }}" @if($parent->id == old('parent_id', $category->parent_id) ) selected @endif >{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
        <p class="invalid-feedback"> {{ $message }} </p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Description:</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror"> {{ old('description', $category->description) }} </textarea>
    @error('description')
        <p class="invalid-feedback"> {{ $message }} </p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Image:</label>
    <input type="file" name="image" value="{{ $category->image }} " class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <p class="invalid-feedback"> {{ $message }} </p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">sataus:</label>
    <div>
        <label><input type="radio" name="sataus" value="active" @if(old('sataus', $category->sataus) == 'active' ) checked @endif>
            Active</label>
        <label><input type="radio" name="sataus" value="inactive" @if(old('sataus', $category->sataus) == 'inactive' ) checked @endif>
            Inactive</label> 
    </div>
    @error('sataus')
        <p class="invalid-feedback"> {{ $message }} </p>
    @enderror
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'Save'}}</button>
</div>