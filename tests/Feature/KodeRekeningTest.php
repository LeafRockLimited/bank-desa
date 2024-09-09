<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class KodeRekeningTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store(): void
    {
        $user = User::first();
        $data = [
            'kode_rekening' => '4.0.1.2.312',
            'jenis_saldo' => '2',
            'nama_kode_rekening' => 'Test',
        ];
        $response = $this->actingAs($user)->post(route('kode_rekening.store'),$data);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->get(route('kode_rekening.show'));
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $user = User::first();
        $data = [
            'kode_rekening' => '401234567',
            'jenis_saldo' => '4',
            'nama_kode_rekening' => 'Test2',
        ];
        $id = '2';
        $response = $this->actingAs($user)->put(route('kode_rekening.update',$id),$data);
        $response->assertStatus(200);
    }

    public function test_delete(): void
    {
        $user = User::first();
        $id = '2';
        $response = $this->actingAs($user)->delete(route('kode_rekening.delete',$id));
        $response->assertStatus(200);
    }
}
