<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- @vite('resources/js/form_center.js') --}}
        
        <title>Posty</title>
    </head>
    <body>
        <tbody>
            <div align="center">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imie</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Dodany</th>
                            <th>Ostatnio modyfikowany</th>
                        </tr>
                    </thead>
                    @foreach($posts as $post)
                    <tbody>
                        <tr>
                            <th>{{ $post->id }}</th>
                            <th id="name<?php echo $post->id; ?>" contenteditable="false">{{ $post->name }}</th>
                            <th id="surname<?php echo $post->id; ?>" contenteditable="false">{{ $post->surname }}</th>
                            <th id="email<?php echo $post->id; ?>" contenteditable="false">{{ $post->email }}</th>
                            <th class="date-time">{{ $post->created_at }}</th>
                            <th class="date-time">{{ $post->updated_at }}</th>
                            <th>
                                <x-primary-button class="edit-button" id="edit<?php echo $post->id; ?>" onclick="editFunction(<?php echo $post->id; ?>)">{{ __('EDYTUJ') }}</x-primary-button>
                                <x-primary-button class="delete-button" id="delete<?php echo $post->id; ?>" onclick="deleteFunction(<?php echo $post->id; ?>)">{{ __("USUŃ") }}</x-primary-button>
                            </th>
                        </tr>                    
                    </tbody>
                    @endforeach
                </table>
            </div>
            
        </tbody>


    </body>
    <script>
        // oblsuga przycisku edycji
        function editFunction(id){
            //console.log(document.getElementById("edit" + id).innerText)
            if(document.getElementById("edit" + id).innerText == "EDYTUJ"){
                // wlaczenie edycji pol
                document.getElementById("name" + id).contentEditable = "true";
                document.getElementById("surname" + id).contentEditable = "true";
                document.getElementById("email" + id).contentEditable = "true";
                // zmiana textu przycisku edycji
                document.getElementById("edit" + id).innerText = "ZAPISZ";
                // zmiana textu przycisku usuwania
                document.getElementById("delete" + id).innerText = "ANULUJ";
            }else{
                // zapisanie wartosci z pol
                var name = document.getElementById("name" + id).innerText;
                var surname = document.getElementById("surname" + id).innerText;
                var email = document.getElementById("email" + id).innerText;
                
                // wyslanie danych do serwera przez AJAX
                $.ajax({
                    url: '/update-post', // route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        name: name,
                        surname: surname,
                        email: email
                    },
                    success: function(response){
                        // wylaczenie edycji pol
                        document.getElementById("name" + id).contentEditable = "false";
                        document.getElementById("surname" + id).contentEditable = "false";
                        document.getElementById("email" + id).contentEditable = "false";
                        // zmiana textu przycisku
                        document.getElementById("edit" + id).innerText = "EDYTUJ";

                        alert('Rekord został zaktualizowany');
                        // odswiezenie okna
                        window.location.reload();
                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseText); // pelna odp serwera
                        alert('Wystąpił błąd przy aktualizacji rekordu')
                    }
                });

                
            }
            
        }

        // obsluga przycisku do usuwania
        function deleteFunction(id){
            if(document.getElementById("delete" + id).innerText == "ANULUJ"){
                // wylaczenie edycji pol
                document.getElementById("name" + id).contentEditable = "false";
                document.getElementById("surname" + id).contentEditable = "false";
                document.getElementById("email" + id).contentEditable = "false";
                // zmiana textu przycisku edycji
                document.getElementById("edit" + id).innerText = "EDYTUJ";
                // zmiana textu przycisku usuwania
                document.getElementById("delete" + id).innerText = "USUŃ";
            }else{

                var name = document.getElementById("name" + id).innerText;
                var surname = document.getElementById("surname" + id).innerText;

                if(confirm('Czy na pewno chcesz usunąć rekord ' + name + ' ' + surname + ' o id = ' + id + '?')) {
                    // wyslanie danych do serwera przez AJAX
                    $.ajax({
                        url: '/delete-post', // route
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function(response){
                            alert('Rekord został usunięty');
                            // odswiezenie okna
                            window.location.reload();
                        },
                        error: function(xhr, status, error){
                            console.log(xhr.responseText); // pelna odp serwera
                            alert('Wystąpił błąd przy usuwaniu rekordu')
                        }
                    });
                }else{
                    console.log('Usunięcie rekordu anulowane.');
                }
                
            }
        }
    </script>
</x-app-layout>