<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        $usuarios = DB::table('cao_usuario')->get();

        $co_sistema = "1";
        $IN_ATIVO = "S";
        $CO_TIPO_USUARIO = ["0","1", "2"];

        $resultado = DB::table('cao_usuario')->join("permissao_sistema", "cao_usuario.co_usuario", "=", "permissao_sistema.co_usuario")

        ->select("cao_usuario.co_usuario","cao_usuario.no_usuario", "permissao_sistema.co_tipo_usuario")

        ->where("permissao_sistema.co_sistema", "=", $co_sistema)
        ->where("permissao_sistema.in_ativo","=",$IN_ATIVO)
        ->where("permissao_sistema.co_tipo_usuario","=",$CO_TIPO_USUARIO[0])
        ->orwhere("permissao_sistema.co_tipo_usuario","=",$CO_TIPO_USUARIO[1])
        ->orwhere("permissao_sistema.co_tipo_usuario","=",$CO_TIPO_USUARIO[2])
        ->get();


        return view('comercial', compact('resultado'));
    }

  public function ajax(Request $request){

        $arrayResult=[];
        $mesFrom=$request->data['mesFrom'];
        $mesTo=$request->data['mesTo'];
        $anioFrom=$request->data['anioFrom'];
        $anioTo=$request->data['anioTo'];
        $usuarios=$request->data['usuarios'];

/*Para ello, revisa la tabla CAO_FATURA,
allí obtendrás facturas emitidas por la empresa, relacionadas a un  cliente  (CO_CLIENTE),  a  un  sistema  (CO_SISTEMA)
y  a  una  orden  de  servicio  (CO_OS)  en  una  fecha determinada (DATA_EMISSAO). */
        $query = DB::table('cao_os')->join("cao_fatura", "cao_fatura.co_os", "=", "cao_os.co_os")
        ->join("cao_usuario", "cao_os.co_usuario", "=", "cao_usuario.co_usuario")
        ->select(DB::raw('cao_os.co_usuario as usuario,
        cao_usuario.no_usuario as nombre,
        cao_fatura.valor as valor,
        cao_fatura.total_imp_inc as impuesto,
        MONTH(cao_fatura.data_emissao) as mes,
        YEAR(cao_fatura.data_emissao) as anio,
        cao_fatura.comissao_cn as comision'
        ))
         //->where("cao_os.co_usuario","=",$usuarios)
        ->whereIn('cao_os.co_usuario',$usuarios)
        ->whereBetween(DB::raw('Month(cao_fatura.data_emissao)'), [$mesFrom, $mesTo])
        ->whereBetween(DB::raw('Year(cao_fatura.data_emissao)'), [$anioFrom, $anioTo])
        ->get();

        $costos = DB::table('cao_salario')
        ->select('cao_salario.brut_salario')
        ->whereIn('cao_salario.co_usuario',$usuarios)
        ->get();

        $total=0;
        $promediocosto=0;

        foreach ($costos as $item){
            $total+=$item->brut_salario;

        }
        if($total>0)
        $promediocosto=$total/count($costos);

        $json=array();
        $cont=0;
        foreach ($query as $item) {
            # code...
            $json[$cont]['nombre']=$item->nombre;
            $json[$cont]['usuario']=$item->usuario;
            $json[$cont]['costopromedio']=$promediocosto;

            //Duda en cuanto al porciento a calcular del impuesto.
           $recetaLiquida=$item->valor-($item->valor*$item->impuesto/100);

            $json[$cont]['recetaliquida']=$recetaLiquida;
            $json[$cont]['mes']=$item->mes;
            $json[$cont]['anio']=$item->anio;
            $json[$cont]['costofijo']=$this->custoFixo($item->usuario);
            $porcientocomision=$recetaLiquida*$item->comision/100;
            $porcientoimpuesto=$item->impuesto*$item->valor/100;
            $comision=($item->valor-($item->valor*$porcientoimpuesto))*$porcientocomision;
            $json[$cont]['comision']=$comision;
            $lucro=$recetaLiquida-($this->custoFixo($item->usuario)+$comision);
            $json[$cont]['lucro']=$lucro;
            $cont++;


        }

    return json_encode($json);
        }


    //busca el costo fijo al pasarle un usuario;
    public function custoFixo($usuario)
    {

        $query1 = DB::table('cao_salario')
        ->select('cao_salario.brut_salario')
        ->where('cao_salario.co_usuario',"=",$usuario)
        ->get();
        $salariobruto=0;
        foreach($query1 as $item){
        $salariobruto=$item->brut_salario;
        }
        return $salariobruto;

    }

    public function pie(Request $request){

        $usuarios=$request->data['usuarios'];

        $query = DB::table('cao_os')->join("cao_fatura", "cao_fatura.co_os", "=", "cao_os.co_os")
        ->join("cao_usuario", "cao_os.co_usuario", "=", "cao_usuario.co_usuario")
        ->select(DB::raw('cao_os.co_usuario as usuario,
        cao_usuario.no_usuario as nombre,
        cao_fatura.valor as valor,
        cao_fatura.total_imp_inc as impuesto'
        ))
         //->where("cao_os.co_usuario","=",$usuarios)
        ->whereIn('cao_os.co_usuario',$usuarios)
        ->get();

        $json=array();
        $cont=0;
        $total=0;
        foreach($query as $item){

            $total+=($item->valor-$item->impuesto);
        }

        foreach ($query as $item) {
            # code...
            $json[$cont]['nombre']=$item->nombre;
            $json[$cont]['usuario']=$item->usuario;
            $recetaLiquida=$item->valor-($item->valor*$item->impuesto/100);
            $total+=$recetaLiquida;
            $json[$cont]['recetaliquida']=$recetaLiquida;
            $json[$cont]['porciento']=$recetaLiquida*100/$total;
            $cont++;


        }

        foreach($json as $item){

        }

    return json_encode($json);

    }




}
