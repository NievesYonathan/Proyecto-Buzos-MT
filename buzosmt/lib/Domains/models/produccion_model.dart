import 'dart:convert';
import 'package:buzosmt/Data/repositories/production_repository.dart';

// import '../../Data/repositories/production_repository.dart';
class Produccion {
  
  final ProductionRepository productionObj = ProductionRepository();

  Future<Map<String, dynamic>> productionUpdate(
    int proId,
    String proNombre,
    String proFechaInicio,
    String proFechaFin,
    int proCantidad,
    int proEtapa,
  ) async {
    final produccion = {
      'proNombre': proNombre,
      'proFechaInicio': proFechaInicio,
      'proFechaFin': proFechaFin,
      'proCantidad': proCantidad,
      'proEtapa': proEtapa,
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
    int proEtapa,
  ) async {
    final produccion = {
      'proNombre': proNombre,
      'proFechaInicio': proFechaInicio,
      'proFechaFin': proFechaFin,
      'proCantidad': proCantidad,
      'proEtapa': proEtapa,
    };
    final data = jsonEncode(produccion);
    final status = await productionObj.create(data);
    return status;
  }

  Future<Map<String, dynamic>> productionShow(int proId) async {
    final status = await productionObj.getProdducion(proId);
    return status;
  }
  Future<List<dynamic>> productionGet() async {
    final status = await productionObj.getProducciones();
    return status;
  }
  Future<Map<String, dynamic>> productionDelete(int proId) async {
    final status = await productionObj.delete(proId);
    return status;
  }
}
