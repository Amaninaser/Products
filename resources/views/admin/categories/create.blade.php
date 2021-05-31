<x-dashboard-layout title="Create New Category">

    <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form',[
        'button_lable' => 'Add'
        ])

    </form>
</x-dashboard-layout>