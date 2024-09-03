<x-app-layout>
    <head>
        <link rel="stylesheet" href="/css/friends.css" />
    </head>
    <body>
        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Friends') }}
                </h2>
            </div>
        </x-slot>

        <div class="friend-container flex">
            @foreach($friendsData as $friend)
            <div class="mt-3 mr-3 ml-3">

                <a href="/friends/{{ $friend['id'] }}">
                    <img src="{{ asset('storage/' . $friend['path']) }}" alt="Photo" style="width: 200px; height: 200px; object-fit: cover;"/>
                    <div>
                        <p class="flex justify-center"><strong>{{ $friend['name'] }}</strong></p>
                        {{-- <p class="flex justify-center">{{ $friend['status'] }}</p> --}}
                    </div>
                    {{-- @if(session('status'))
                        <div class="alert alert-success mt-3" align="center">
                            {{ session('status') }}
                        </div>
                    @endif --}}
                    @if ($friend['status'] == 'pending')
                        
                        <!-- Zaproszenie wyslane przez usera -->
                        @if ($friend['id'] != $friend['sender_id'])
                            <p class="flex justify-center">Invite sent</p>
                            <div class="flex justify-center" width="200px">
                                {{-- <div class="">
                                    <button class="button-80" style="background: #5550ee; color: white;" role="button">Accept</button>
                                </div> --}}
                                <form action="{{ route('friends.delete', $friend['relation_id']) }}" method="POST">
                                    @csrf
                                    <button class="button-80" role="button" type="submit">Cancel</button>
                                </form>
                            </div>
                        
                        <!-- Zaproszenie od innego usera -->
                        @else
                            <p class="flex justify-center">Invited you</p>
                            <div class="flex justify-center" width="200px">
                                <div class="">
                                    <form action="{{ route('friends.accept', $friend['relation_id']) }}" method="POST">
                                        @csrf
                                        <button class="button-80" style="background: #5550ee; color: white;" role="button" type="submit">Accept</button>
                                    </form>
                                </div>
                                <div class="">
                                    <form action="{{ route('friends.delete', $friend['relation_id']) }}" method="POST">
                                        @csrf
                                        <button class="button-80" role="button" type="submit">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else

                        <!-- Trwajaca przyjazn -->
                        <p class="flex justify-center">Friend</p>
                        <div class="flex justify-center" width="200px">
                            <div class="">
                                <form action="{{ route('friends.delete', $friend['relation_id']) }}" method="POST" onsubmit="return confirmDelete()">
                                    @csrf
                                    <button class="button-80" role="button" style="background: #db7474; color: white;" type="submit">Remove friend</button>
                                </form>
                            </div>
                        </div>
                    
                    @endif
                    
                </a>

                
            </div>
            @endforeach

            
        </div>
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to remove this friend?');
            }
        </script>
    </body>
</x-app-layout>