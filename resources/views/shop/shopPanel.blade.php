<x-app-layout>
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
        <style>
            .styled-table {
                width: 90%;
                border-collapse: collapse; /* Zapewnia, że granice się łączą */
                border: 1px solid #ddd; /* Granica wokół całej tabeli */
            }
            .styled-table th, .styled-table td {
                border: 1px solid #ddd; /* Granice komórek */
                padding: 8px; /* Padding w komórkach */
                text-align: left; /* Wyrównanie tekstu w lewo */
            }
            .styled-table th {
                background-color: #f4f4f4; /* Tło nagłówków */
                font-weight: bold; /* Pogrubienie nagłówków */
            }
            .styled-table tr:nth-child(even) {
                background-color: #f9f9f9; /* Tło co drugiego wiersza */
            }
            .styled-table tr:hover {
                background-color: #f1f1f1; /* Tło wiersza przy najechaniu */
            }

            #popupDialog {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 20px;
                background-color: #fff;
                border: 1px solid #ccc;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }

            #overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
        </style>
    </head>
    <body>
        <div id="overlay">
            <div id="popupDialog" class="flex">
                <h2 align="center">Order Details</h2>
                <div id="orderDetails"></div>
                <div class="flex flex-row-reverse">
                    <button onclick="closeFn()">Close</button>
                </div>
                
            </div>
        </div>
        <tbody>
            <div align="center">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Items</th>
                            {{-- <th>Name</th>
                            <th>Surname</th>
                            <th>E-mail</th>
                            <th>Number</th> --}}
                            <th>Note</th>
                            <th>Order placed</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    @foreach($orders as $order)
                    <tbody >
                        <tr >
                            <td>{{ $order->id }}</td>
                            <td id="items<?php echo $order->id; ?>">
                                @php
                                    // Decode JSON data into an array
                                    $items = json_decode($order->items, true);
                                @endphp

                                @if (is_array($items))
                                    <ul>
                                        @foreach ($items as $item)
                                            <li>
                                                {{ $item['quantity'] }} x <strong>{{ $item['name'] }} (ID: {{ $item['id'] }})</strong>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    No items
                                @endif
                            </td>
                            <td style="max-width: 250px">{{ $order->note }}</td>
                            {{-- <td id="name<?php echo $order->id; ?>">{{ $order->customer_name }}</td>
                            <td id="surname<?php echo $order->id; ?>">{{ $order->customer_surname }}</td>
                            <td id="email<?php echo $order->id; ?>">{{ $order->customer_email }}</td>
                            <td id="number<?php echo $order->id; ?>">{{ $order->customer_phone }}</td> --}}
                            <td class="date-time">{{ $order->created_at }}</td>
                            <td id="status<?php echo $order->id; ?>">{{ $order->status }}</td>
                            <td style="text-align: center;">
                                <x-primary-button class="details-button" id="details<?php echo $order->id; ?>" data-id="{{ $order->id }}" onclick="popupDetails(this)">{{ __('DETAILS') }}</x-primary-button>
                                <x-primary-button class="edit-button" id="sent<?php echo $order->id; ?>" onclick="editFunction(<?php echo $order->id; ?>)">{{ __('SENT') }}</x-primary-button>
                                <x-primary-button class="edit-button" id="edit<?php echo $order->id; ?>" onclick="editFunction(<?php echo $order->id; ?>)">{{ __('COMPLETE') }}</x-primary-button>
                                <x-primary-button class="delete-button" id="delete<?php echo $order->id; ?>" onclick="deleteFunction(<?php echo $order->id; ?>)">{{ __("CANCEL") }}</x-primary-button>
                            </td>
                        </tr>                    
                    </tbody>
                    @endforeach
                </table>
            </div>
            
        </tbody>


        <script>
            function popupDetails(buttonElement) {
                var orderId = buttonElement.getAttribute('data-id');

                fetch(`/order-details/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        // przedmioty
                        let itemsHtml = '';
                        if (data.items && Array.isArray(data.items)) {
                            itemsHtml = data.items.map(item => `
                                <li>
                                    ${item.quantity} x <strong>${item.name} (ID: ${item.id})</strong>
                                </li>
                            `).join('');
                        }
                        // dane do popupa
                        document.getElementById("orderDetails").innerHTML = `
                            <ul><strong>Items:</strong> ${itemsHtml}</ul>
                            <p><strong>Note:</strong> ${data.note}</p>
                            <p><strong>Price:</strong> $${data.price}</p>
                            <p><strong>Status:</strong> ${data.status}</p>
                            <p><strong>Name:</strong> ${data.customer_name}</p>
                            <p><strong>Surname:</strong> ${data.customer_surname}</p>
                            <p><strong>E-mail:</strong> ${data.customer_email}</p>
                            <p><strong>Number:</strong> ${data.customer_phone}</p>
                            <p><strong>Country:</strong> ${data.country} </p>
                            <p><strong>State:</strong> ${data.state} </p>
                            <p><strong>City:</strong> ${data.city} </p>
                            <p><strong>Postal code:</strong> ${data.postal_code} </p>
                            <p><strong>Address:</strong> ${data.address_line_1}</p>
                            <p><strong>Additional address:</strong> ${data.address_line_2} </p>
                        `;
                    });

                document.getElementById(
                    "overlay"
                ).style.display = "block";
                document.getElementById(
                    "popupDialog"
                ).style.display = "block";
            }

            function loadOrderDetails(id) {
                
            }

            function closeFn() {
                document.getElementById(
                    "overlay"
                ).style.display = "none";
                document.getElementById(
                    "popupDialog"
                ).style.display = "none";
            }
        </script>
    </body>
</x-app-layout>
