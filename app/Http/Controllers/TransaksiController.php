<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Tiket;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::all();
        return response()->json([
            'status' => '200',
            'message' => 'data berhasil dikirim',
            'data' => $transaksi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tiket = Tiket::find($request->id);
        $harga_tiket = $tiket->harga;
        $total_harga = $request->jumlah_tiket * $harga_tiket;
        if($total_harga != 0){
            $pajak = $total_harga * (1/100);
            $tiket->stok = $tiket->stok - $request->jumlah_tiket;
            $tiket->save();
            $transaksis = Transaksi::create([
                'transaksi_id' => uniqid(),
                'jumlah_tiket' => $request->jumlah_tiket,
                'harga_tiket' => $harga_tiket,
                'total_harga' => $total_harga,
                'nama_konser' => $tiket->nama_konser,
                'alamat_konser' => $tiket->alamat,
                'tanggal_konser' => $tiket->tanggal_konser,
                'pajak' => $pajak,
            ]);
            return response()->json([
                'status' => 200,
                'message' => "data berhasil dibuat",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 406,
                'message' => "jumlah_tiket tidak bisa 0",
                'data' => 'null'
            ], 406);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksis = Transaksi::find($id);
        if($transaksis){
            return response()->json([
                'status' => 200,
                'message' => "data berhasil dikirim",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "transaksi id $id  tidak ditemukan",
                'data' => 'null'
            ], 404);
        };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->id != null){
            $transaksis = Transaksi::find($id);
            $tiket = Tiket::find($request->id);
            $harga_tiket = $tiket->harga;
            $total_harga = $request->jumlah_tiket * $harga_tiket;
            $pajak = $total_harga * (1/100);
            $tiket->stok = $tiket->stok - $request->jumlah_tiket;
            $tiket->save();
            if($transaksis){
                if($request->jumlah_tiket != 0){
                    $transaksis->transaksi_id = $transaksis->transaksi_id;
                    $transaksis->total_harga = $total_harga;
                    $transaksis->jumlah_tiket = $request->jumlah_tiket;
                    $transaksis->harga_tiket = $harga_tiket;
                    $transaksis->nama_konser = $tiket->nama_konser;
                    $transaksis->alamat_konser = $tiket->alamat;
                    $transaksis->tanggal_konser = $tiket->tanggal_konser;
                    $transaksis->pajak = $pajak;
                    $transaksis->save();
                    return response()->json([
                        'status' => 200,
                        'message' => 'data berhasil diubah',
                        'data' => $transaksis
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 418,
                        'message' => "jumlah_tiket tidak boleh  0", 
                        'data' => 'null'
                    ], 418);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "transaksi id $id tidak ditemukan", 
                    'data' => 'null'
                ], 404);
            };
        } else {
            return response()->json([
                'status' => 418,
                'message' => "tiket_id dibutuhkan", 
                'data' => 'null'
            ], 418);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksis = Transaksi::where('id', $id)->first();
        if($transaksis){
            $transaksis->delete();
            return response()->json([
                'status' => 200,
                'message' => "data berhasil dihapus",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "transaksi id $id tidak ditemukan",
                'data' => 'null'
            ], 404);
        }
    }
}
