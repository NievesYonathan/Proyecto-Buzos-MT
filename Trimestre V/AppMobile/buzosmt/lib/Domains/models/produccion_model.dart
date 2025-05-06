import 'dart:convert';
import 'package:buzosmt/Data/repositories/production_repository.dart';

// import '../../Data/repositories/production_repository.dart';
class Produccion {
  
  final ProductionRepository productionObj = ProductionRepository();

  Future<Map<String, dynamic>> productionUpdate(
    int proId,
    String proNombre,
    String proFechaFin,
    int proCantidad,
    int ? proEtapa,
  ) async {
    final produccion = {
      'produccion_nombre' : proNombre,
    'produccion_fecha_fin': proFechaFin,
    'produccion_cantidad': proCantidad,
    'produccion_etapa': proEtapa
    };
    final data = jsonEncode(produccion);
    final status = await productionObj.update(proId,data);
    return status;
  }

  Future<Map<String, dynamic>> productionCreate(
    String proNombre,
    String proFechaInicio,
    String proFechaFin,
    int proCantidad,
    int ? proEtapa,
  ) async {
    final produccion = {
      'pro_nombre' : proNombre,
    'pro_fecha_inicio': proFechaInicio,
    'pro_fecha_fin': proFechaFin,
    'pro_cantidad': proCantidad,
    'pro_etapa': proEtapa
    };
    final data = jsonEncode(produccion);
    final status = await productionObj.create(data);
    return status;
  }

  Future<Map<String, dynamic>> productionShow(int proId) async {
    final status = await productionObj.getProdducion(proId);
    return status;
  }
  Future<Map<String, dynamic>> productionGet() async {
    final status = await productionObj.getProducciones();
    return status;
  }
  Future<Map<String, dynamic>> productionDelete(int proId) async {
    final status = await productionObj.delete(proId);
    return status;
  }
  Future<Map<String, dynamic>> productionMateria() async {
    final status = await productionObj.getProduccionMateria();
    return status;
  }
}
