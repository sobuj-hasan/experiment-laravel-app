<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div id="error-message" style="color: red;"></div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
                <input id="phone" class="block mt-1 w-full" type="number" name="phone" value="" required autocomplete="username" />
                <button type="button" id="button" class="btn btn-info" title="Edit" data-item=""> Send </button>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" ></script>
    <script>
        $(document).ready(function() {
            // Get references to the input field and the button
            const inputField = document.getElementById("phone");
            const button = document.getElementById("button");

            // Add an event listener to the input field to listen for input changes
            inputField.addEventListener("input", function() {
                // Get the current value of the input field
                const inputValue = inputField.value;
                // Update the data-item attribute of the button with the input value
                button.setAttribute("data-item", inputValue);
            });

            // Add a click event handler for the "Send" button
            $('#button').click(function() {
                // Get the data-item attribute value from the button
                var dataItemValue = $(this).attr('data-item');
                
                $.ajax({
                    url: "/phone/verify", // Replace with your controller endpoint
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        phone: dataItemValue
                    },
                    success: function(response) {
                        // Handle the response from the server
                        // console.log(response);
                        $('#error-message').text(response);
                    },
                    error: function(error) {
                        // Handle any errors that occur during the AJAX request
                        console.error(error);
                    }
                });
            });
        });
    </script>
</x-guest-layout>
