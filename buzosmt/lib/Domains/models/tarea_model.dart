import 'dart:convert';
import '../../Data/repositories/tarea_repostitory.dart';
class Tarea  { 
  final int ? tarId;
  final String ? tarNombre;
  final String ? tarDescripcion;
  final EtapaRepository tareaObj = EtapaRepository();

  Tarea({ this.tarNombre,  this.tarDescripcion, this.tarId});

  Future<Map<String, dynamic>> tareaUpdate() async {
    final int ? etaId = tarId; 
    final Map<String, dynamic> etapa = {
      'eta_nombre': tarNombre,
      'eta_descripcion': tarDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await tareaObj.updateTarea(etaId, data);
    return status;
  
  }
  Future<Map<String, dynamic>> tareaStore(String tarNombre,String tarDescripcion) async {
    final Map<String, dynamic> etapa = {
      'tar_nombre': tarNombre,
      'tar_descripcion': tarDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await tareaObj.createTarea(data);
    return status;
  }
  Future<Map<String, dynamic>> tareaShow() async {
    final status = await tareaObj.getTareaById(tarId);
    return status;
  }
  Future<List<dynamic>> tareaGet() async {
    final status = await tareaObj.getTarea();
    return status;
  }

}
