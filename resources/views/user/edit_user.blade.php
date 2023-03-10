<x-app-layout>
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="md:m-4 px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Use a permanent address where you can receive mail.
                    </p>
                </div>

                @error('email', 'name')
            <div class="alert-content md:m-4 md:col-span-1">
                <div class="alert-title font-semibold text-lg text-red-800">
                    Error
                </div>
                <div class="alert-description text-sm text-red-600">
                    {{$message}}
                </div>
                @enderror

                @if(session('success'))
                <div class="alert-content md:m-4 md:col-span-1">
				<div class="alert-title font-semibold text-lg text-green-800">
					Success
				</div>
				<div class="alert-description text-sm text-green-600">
					Successfully updated user details!!
				</div>
			</div>
                @endif

            </div>

                <div class="m-2 md:m-4 md:col-span-2">
                    <form action="/dashboard/user/edit/update" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700">Username</label>
                                        <input type="text" name="name" id="name" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{Auth::user()->name}}">
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email
                                            address</label>
                                        <input type="text" name="email" id="email" autocomplete="email"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            value="{{Auth::user()->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-app-layout>