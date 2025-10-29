<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center justify-center px-4 py-2 
            bg-blue-600
            border border-transparent rounded-xl 
            font-semibold text-xs text-white uppercase tracking-widest 
            hover:opacity-90 focus:ring-2 focus:ring-blue-400 
            focus:ring-offset-2 focus:outline-none 
            transition ease-in-out duration-200'
    ]) }}>
    {{ $slot }}
</button>
