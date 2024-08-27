<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // informacje o zamowionych przedmiotach
            $table->json('items'); 
            
            // cena calkowita zamowienia
            $table->decimal('price', 8, 2);
            
            // uwagi do zamowienia
            $table->text('note')->nullable();
            
            // dane klienta
            $table->string('customer_name'); // imie i nazwisko
            $table->string('customer_email'); // email 
            $table->string('customer_phone')->nullable(); // telefon klienta, opcjonalne
            
            // adres dostawy
            $table->string('address_line_1'); // 1 linia adresu
            $table->string('address_line_2')->nullable(); // dodatkowa linia adresu, opcjonalna
            $table->string('city'); //miasto
            $table->string('state')->nullable(); // wojewodztwo / stan, opcjonalne
            $table->string('postal_code'); // kod pocztowy
            $table->string('country'); // kraj
            
            // stan zamowienia
            $table->string('status')->default('pending'); // status zamówienia np. 'pending', 'processing', 'shipped', 'completed', 'cancelled' ; domyslnie pending

            // pola do relacji z innymi tablicami
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // relacja z tabela uzytkownikow (jesli istnieje)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
