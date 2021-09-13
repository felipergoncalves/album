<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::all();
        return view('/pages/home', ['photos'=>$photos]);
    }

    public function showAll(){
      $photos = Photo::all();
      return view('/pages/photo_list',['photos' => $photos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages/photo_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
  {
    //Criação de um um objeto do tipo Photo
    $photo = new Photo();
    //Alterando os atributos do objeto
    $photo->title = $request->title;
    $photo->date = $request->date;
    $photo->description = $request->description;
    //upload
    if($request->hasFile('photo') && $request->file('photo')->isValid()){
      //Define um nome aleatório para a foto, com base na data atual
      $nomeFoto = sha1(uniqid(date('HisYmd')));
      //Recupera a extensão do arquivo
      $extensao = $request->photo->extension();
      //Define o nome do arquivo com a extensão
      $nomeArquivo = "{$nomeFoto}.{$extensao}";
      //faz o upload
      $upload = $request->photo->move(public_path('/storage/photos'),$nomeArquivo);
      //Adicinando o nome do arquivo ao atributo photo_url
      $photo->photo_url = $nomeArquivo;
    }
    //Se tudo deu certo, salva no bd
    if($upload){
      //Inserindo no banco de dados
      $photo->save();
    }
    //Redirecionar para a página inicial
    return redirect('/');
  }//fim do store

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('pages/photo_form',['photo'=>$photo]);
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
        $photo = Photo::findOrfail($request->id);

        //Alterando os atributos do objeto
        $photo->title = $request->title;
        $photo->date = $request->date;
        $photo->description = $request->description;
        $photo->photo_url = 'teste';

        //alterando no banco de dados
        $photo->update();

        //redirecionar para a página de fotos
        return redirect('/photos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //retorna e exclui a foto do banco de dados
        Photo::findOrFail($id)->delete();

        //redirecionar para a página lista de fotos
        return redirect('/photos');
    }
}
