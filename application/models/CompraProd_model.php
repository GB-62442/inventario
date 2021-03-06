<?php
defined('BASEPATH') OR exit('No se permite el acceso directo.');

class CompraProd_model extends CI_Model{

	public function getAll(){
		$this->db->select('idProducto, unidadMedida, producto.nombre as nombreproducto, precioVenta, producto.idProveedor, proveedor.nombre as nombreproveedor from producto left join proveedor on proveedor.idProveedor = producto.idProveedor', FALSE);

		$rs = $this->db->get();

		return $rs->num_rows() > 0 ? $rs->result() : NULL;
	}

	public function insertc($data){
		return $this->db->insert('comprasproducto', $data) ? true : NULL;
	}

	public function insertpv($data){
		return $this->db->insert('puntoventaproducto', $data) ? true : NULL;
	}   


 	public function getById($id, $inicio, $final)
    {
        $cmd = "SELECT DISTINCT producto.idProducto, producto.nombre as nombreproducto, producto.unidadMedida, precioVenta, proveedor.idProveedor, proveedor.nombre as nombreproveedor, fecha, comprasproducto.cantidad, comprasproducto.precio as costo FROM comprasproducto inner join producto on comprasproducto.idProducto=producto.idProducto inner join puntoventaproducto on puntoventaproducto.idProducto= producto.idProducto inner join proveedor on proveedor.idProveedor= producto.idProveedor where producto.idProducto  = ".$id;

        $busqueda = "";
        if($inicio!= null && $inicio != "" && $final != null && $final != ""){
        	$busqueda = " AND date(fecha) BETWEEN CAST('".$inicio."' AS DATE) AND CAST('".$final."' AS DATE)";

        }

        $cmd  =$cmd.$busqueda." order by fecha desc";

        $query = $this->db->query($cmd);
		return $query->num_rows() > 0 ? $query->result() : NULL;
    }


}

