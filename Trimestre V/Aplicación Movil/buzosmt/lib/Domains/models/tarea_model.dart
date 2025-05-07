import 'dart:convert';
import '../../Data/repositories/tarea_repostitory.dart';

class Tarea {
  final int? tarId;
  final String? tarNombre;
  final String? tarDescripcion;
  final int? tarEstado;
  final EtapaRepository tareaObj = EtapaRepository();

  Tarea({this.tarNombre, this.tarDescripcion, this.tarId, this.tarEstado});

  Future<Map<String, dynamic>> tareaUpdate(
    int? tarId,
    String? tarNombre,
    String? tarDescripcion,
    int? tarEstado,
  ) async {
    final int? etaId = tarId;
    final Map<String, dynamic> etapa = {
      'id_tarea': tarId,
      'tar_nombre': tarNombre,
      'tar_descripcion': tarDescripcion,
      'tar_estado': tarEstado,
    };
    final String data = jsonEncode(etapa);
    final status = await tareaObj.updateTarea(etaId, data);
    return status;
  }

  Future<Map<String, dynamic>> tareaStore(
    String tarNombre,
    String tarDescripcion,
  ) async {
    final Map<String, dynamic> etapa = {
      'tar_nombre': tarNombre,
      'tar_descripcion': tarDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await tareaObj.createTarea(data);
    return status;
  }

  Future<List<dynamic>> tareaGet() async {
    final status = await tareaObj.getTarea();
    return status;
  }
}
