@props(['disabled' => false])

{{-- $attributes is a collection of all the attributes passed down by the component call. --}}
{{-- ->merge then combines all the attributes into a class. For example, this component was called in ../post/create.blade.php with a class="block mt-1 w-full". This class will be combined with the class included in the merge. --}}
<textarea @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
</textarea>
