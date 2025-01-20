<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan LPE</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        .sub-header {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>Nomor Urut</th>
        <th>Urian</th>
        <th>31 Desember 2024</th>
    </tr>
    <tr>
        <td>1</td>
        <td class="header" colspan="2">PENYERTAAAN MODAL</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Penyertaan Modal Desa Awal</td>
        <td>Rp {{ number_format($saldoAwalModalDesa, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Penyertaan Modal Masyarakat Awal</td>
        <td>Rp {{ number_format($saldoAwalModalMasyarakat, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Penambahan Investasi periode berjalan:</td>
        <td>Rp {{ number_format($penyertaanModalAkhir, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Penyertaan Modal Desa</td>
        <td>Rp {{ number_format($saldoModalDesa, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>6</td>
        <td>Penyertaan Modal Masyarakat</td>
        <td>Rp {{ number_format($saldoModalMasyarakat, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>7</td>
        <td>Penyertaan Modal Akhir</td>
        <td>Rp {{ number_format($penyertaanModalAkhir, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>8</td>
        <td class="sub-header" colspan="2">SALDO LABA</td>
    </tr>
    <tr>
        <td>9</td>
        <td>Saldo Laba Awal:</td>
        <td>Rp {{ number_format($saldoLaba, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>10</td>
        <td>Saldo Laba Tidak Dicadangkan</td>
        <td>Rp {{ number_format($saldoLabaTidakDicadangkan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>11</td>
        <td>Saldo Laba Dicadangkan</td>
        <td>Rp {{ number_format($saldoLabaDicadangkan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>12</td>
        <td>Laba (Rugi) periode berjalan</td>
        <td>Rp {{ number_format($labaRugi, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>13</td>
        <td>Bagi Hasil Penyertaan:</td>
        <td>Rp {{ number_format($bagiHasilPenyertaanModalDesa, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>14</td>
        <td>Bagi Hasil Penyertaan Modal Masyarakat</td>
        <td>Rp {{ number_format($bagiHasiPenyertaanModalMasyarakat, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>15</td>
        <td>Saldo Laba Akhir</td>
        <td>Rp {{ number_format($saldoLaba, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>16</td>
        <td class="sub-header" colspan="2">MODAL DONASI/SUMBANGAN</td>
    </tr>
    <tr>
        <td>17</td>
        <td>Modal Donasi/Sumbangan</td>
        <td>Rp {{ number_format($modalDonasiSumbangan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>18</td>
        <td class="sub-header" colspan="2">EKUITAS AKHIR</td>
    </tr>
    <tr>
        <td>19</td>
        <td>Ekuitas Akhir</td>
        <td>Rp {{ number_format($ekuitasAkhir, 0, ',', '.') }}</td>
    </tr>
</table>
</body>
</html>
