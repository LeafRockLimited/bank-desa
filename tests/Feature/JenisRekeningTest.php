<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class JenisRekeningTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store(): void
    {
        $user = User::first();
        $data = [
            'id_jenis' => '4',
            'nama' => 'Pengeluaran',
        ];
        $response = $this->actingAs($user)->post(route('jenis_rekening.store'),$data);

        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $user = User::first();
        $data = [
            'id_jenis' => '4',
            'nama' => 'Pengeluaran2',
        ];
        $id = '3';
        $response = $this->actingAs($user)->put(route('jenis_rekening.update',$id),$data);

        $response->assertStatus(200);
    }


    public function test_show(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->get(route('jenis_rekening.show'));
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_delete(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->delete(route('jenis_rekening.delete', '2'));

        $response->assertStatus(200);
    }
}
