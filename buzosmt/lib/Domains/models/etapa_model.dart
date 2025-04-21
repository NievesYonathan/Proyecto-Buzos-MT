import 'dart:convert';
import '../../Data/repositories/etapa_repostitory.dart';
class Etapa { 
  final int ? etaId;
  final String ? etaNombre;
  final String ? etaDescripcion;
  final EtapaRepository etapaObj = EtapaRepository();

  Etapa({ required this.etaNombre, required this.etaDescripcion, this.etaId});

  Future<Map<String, dynamic>> etapaUpdate() async {
    final int ? etaId = this.etaId; 
    final Map<String, dynamic> etapa = {
      'eta_nombre': etaNombre,
      'eta_descripcion': etaDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await etapaObj.updateEtapa(etaId, data);
    return status;
  
  }
  Future<Map<String, dynamic>> etapaStore() async {
    final Map<String, dynamic> etapa = {
      'eta_nombre': etaNombre,
      'eta_descripcion': etaDescripcion,
    };
    return etapa;
  }
  Future<Map<String, dynamic>> etapaShow() async {
    final status = await etapaObj.getEtapaById(etaId);
    return status;
  }
  Future<Map<String, dynamic>> etapaGet() async {
    final status = await etapaObj.getEtapa();
    return status;
  }
  Future<Map<String, dynamic>> etapaDelete(etaId) async {
    final status = await etapaObj.deleteEtapa(etaId);
    return status;
  }

}
