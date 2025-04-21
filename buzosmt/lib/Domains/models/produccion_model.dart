import 'dart:convert';

// import '../../Data/repositories/production_repository.dart';
class ProduccionModel {
  final String proNombre;
  final DateTime proFechaInicio;
  final DateTime proFechaFin;
  final int proCantidad;
  final String proEtapa;
  final String? proImg;

  ProduccionModel({
    required this.proNombre,
    required this.proFechaInicio,
    required this.proFechaFin,
    required this.proCantidad,
    required this.proEtapa,
    this.proImg
  });

   Future<Map<String, dynamic>> jsonForProduction() async {
    final Map<String, dynamic> produccion = {
      'pro_nombre' : proNombre,
        'pro_fecha_inicio': proFechaInicio,
        'pro_fecha_fin' : proFechaFin,
        'pro_cantidad' : proCantidad,
        'pro_etapa' : proEtapa
    };
    return produccion;
  }
  Future<Map<String, dynamic>> productionUpdate(Map<String, dynamic> produccionData) async {
    final jsonData = await jsonForProduction();
    return jsonData;
  }
  Future<Map<String, dynamic>> productionCreate(Map<String, dynamic> produccionData) async {
    final jsonData = await jsonForProduction();
    return jsonData;
  }
  // Future<Map<String, dynamic>> productionShow(Map<String, dynamic> produccionData) async {
  //   final jsonData = await jsonForProduction(produccionData);
  //   return jsonData;
  // }
  // Future<Map<String, dynamic>> productionGet(Map<String, dynamic> produccionData) async {
  //   final jsonData = await jsonForProduction(produccionData);
  //   return jsonData;
  // }
  // Future<Map<String, dynamic>> productionDelete(Map<String, dynamic> produccionData) async {
  //   final jsonData = await jsonForProduction(produccionData);
  //   return jsonData;
  // }
}