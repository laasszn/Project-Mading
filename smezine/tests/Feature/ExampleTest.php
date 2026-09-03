<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the main public pages load successfully', function () {
    $this->get('/berita')->assertStatus(200);
    $this->get('/galeri')->assertStatus(200);
    $this->get('/tentang')->assertStatus(200);
});
