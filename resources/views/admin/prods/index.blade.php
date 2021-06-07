<x-dashboard-layout title="Products">
<x-alert />

    <div class="table toolbar mb-3">
        <a href="{{ route('admin.prods.create') }}" class="btn btn-info">Create</a>
    </div>

    <form action="{{ route('admin.prods.index') }}" method="get" class="d-flex mb-4">
        <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
        <select name="parent_id" class="form-control me-2">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn  btn-secondary">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Created At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prods as $prod)
            <tr>
                <td>{{ $prod->id }}</td>
                <td><a href="{{ route('admin.prods.edit', $prod->id ) }}">{{ $prod->name }}</a></td>
                <td>{{ $prod->category->name}}</td>
                <td>{{ $prod->price }}</td>
                <td>{{ $prod->quantity }}</td>
                <td>{{ $prod->status }}</td>
                <td>{{ $prod->created_at }}</td>
                <td>
                    <form action="{{ route('admin.prods.destroy', $prod->id ) }}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        {{ $prods->links() }}
</x-dashboard-layout>