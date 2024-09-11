<?php

namespace Tests\Feature;


use Tests\TestCase;

class HomeTest extends TestCase
{
  

    public function TestHomePageIsWorkingCorrectly()
{
    $response = $this->get('/');

    $response->assertSeeText('Laravel App - Home Page');
    $response->assertSeeText('welcome Laravel');
}

public function testContactPageIsWorkingCorrectly(){
    $response = $this->get('/contact');
    $response->assertSeeText('Contact');
    
}

}
