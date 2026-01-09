<?php

use App\Models\Contact;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;

uses(WithFaker::class);

it('can store a contact', function () {
    login()
        ->post('/contacts', [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->e164PhoneNumber,
            'address' => '1 Test Street',
            'city' => 'Testville',
            'region' => 'Testshire',
            'country' => fake()->randomElement(['US', 'GB']),
            'postal_code' => fake()->postcode,
        ])
        ->assertRedirect('/contacts')
        ->assertSessionHas('success', 'Contact created.')
    ;

    $contact = Contact::latest()->first();

    expect($contact->first_name)->toBeString()->not->toBeEmpty();
    expect($contact->last_name)->toBeString()->not->toBeEmpty();
    expect($contact->email)->toBeString()->toContain('@');
    expect($contact->phone)->toBeString()->toContain('+');
    expect($contact->address)->toBe('1 Test Street');
    expect($contact->city)->toBe('Testville');
    expect($contact->region)->toBe('Testshire');
    expect($contact->country)->toBeIn(['US', 'GB']);
});
