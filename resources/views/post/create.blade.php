{{-- Uses layout from the view() of /app/View/Components/AppLayout.php --}}
<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl mb-4">Create New Post</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="text" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="" disabled {{ !old('category_id') ? 'selected' : '' }}>
                                Select a Category
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id === old('category_id') ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <x-input-textarea id="content" class="block mt-1 w-full" name="content">
                            {{ old('content') }}
                        </x-input-textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="text" class="block mt-1 w-full" type="datetime-local" name="published_at"
                            :value="old('published_at', now())" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <x-primary-button class="max-w-fit">Submit</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
