<?php

it('returns a successful redirect response', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});
