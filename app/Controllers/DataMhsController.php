<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataMhsModel;
use App\Models\ProdiModel;
use App\Models\TypeMhsModel;

class DataMhsController extends BaseController
{
    public function index()
    {
        $model = new DataMhsModel();                    //melakukan instanisasi dari model datamhsmodel  *1
        $data['datamhs'] = $model->allData();           //memanggil fungsi alldata() yang ada di model dan ditempatkan di $data['datamhs'] 
        // $data['json'] = json_encode(array(
        //     'datamhs' => $data['datamhs']
        // ));

        // return json_encode(array(
        //     "data" => $data['datamhs']
        // ));
        return view('mahasiswa/index', $data);          //mengarahkan ke view dan mengirimkan isi dari $data
    }

    public function tambah()
    {
        $pmodel = new ProdiModel();                     //melakukan instanisasi dari model prodimodel   *2
        $data['prodi'] = $pmodel->findAll();            //memanggil fungsi findAll() untuk mendapatkan selurh data yang terdapat pada prodimodel *2.1

        $tmodel = new TypeMhsModel();                   //melakukan instanisasi dari model prodimodel
        $data['typemhs'] = $tmodel->findAll();          //memanggil fungsi findAll() untuk mendapatkan selurh data yang terdapat pada typemhsmodel
        
        return view('mahasiswa/tambah_data', $data);    //mengarahkan ke view dan mengirimkan isi dari $data
    }
    public function addData()
    {
        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama' => $this->request->getPost('nama'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'prodi_id' => $this->request->getPost('prodi_id'),
            'type_id' => $this->request->getPost('type_id'),
            'angkatan' => $this->request->getPost('angkatan')
        ];
        $model = new DataMhsModel();                                //*1
        $model->insert($data);                                      //memanggil query untuk memasukkan isi dari $data ke $model
        return redirect()->to('/');                                 //mengarahkan ke halaman awal
    }

    public function editData($id)
    {
        $pmodel = new ProdiModel();                                 //*2
        $data['prodi'] = $pmodel->findAll();                        //*2.1

        $tmodel = new TypeMhsModel();
        $data['typemhs'] = $tmodel->findAll();
        // return view('mahasiswa/edit_data', $data);

        $model = new DataMhsModel();                                //*1
        $data['datamhs'] = $model->find($id);                       // untuk menangkap data dari $model berdasarkan parameter $id dari url
        return view('mahasiswa/edit_data', $data);
    }
    public function prosesEdit()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('datamhs');
        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama' => $this->request->getPost('nama'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'prodi_id' => $this->request->getPost('prodi_id'),
            'type_id' => $this->request->getPost('type_id'),
            'angkatan' => $this->request->getPost('angkatan'),
        ];

        // $model = new DataMhsModel();
        // $model->update('nim', $data);
        if ($builder->replace($data)) {
            return redirect()->to('/');
        }
    }
    public function hapus_data($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('datamhs');
        if ($builder->delete(['nim' => $id])) {
            return redirect()->to('/');
        }
        // $model = new DataMhsModel();
        // $model->delete($id);
    }
}
