<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Tạo quản trị viên' }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ 'Tạo quản trị viên' }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form wire:submit.prevent="save">
                        <div>
                            <x-input-label for="name" value="Tên"/>
                            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full"
                                          type="text" name="name" required/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" value="Địa chỉ Email"/>
                            <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full"
                                          type="email" name="email" required/>
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" value="Mật khẩu"/>
                            <x-text-input wire:model.defer="password" id="password" class="block mt-1 w-full"
                                          type="password" name="password" required/>
                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="is_admin" value="Admin"/>
                            <x-text-input wire:model.defer="is_admin" id="is_admin" class="block mt-1"
                                          type="checkbox" name="is_admin"/>
                            <x-input-error :messages="$errors->get('is_admin')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                Lưu
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
