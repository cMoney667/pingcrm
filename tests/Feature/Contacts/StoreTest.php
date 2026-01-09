<?php

use App\Models\Contact;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;

uses(WithFaker::class);

it('can store a contact', function () {
    login()
        ->post('/contacts', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => '1 Test Street',
            'city' => 'Testville',
            'region' => 'Testshire',
            'country' => $this->faker->randomElement(['US', 'GB']),
            'postal_code' => $this->faker->postcode,
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
