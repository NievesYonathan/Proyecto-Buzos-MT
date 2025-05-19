import 'dart:convert';
import '../../Data/repositories/etapa_repostitory.dart';
class Etapa { 
  final int ? etaId;
  final String ? etaNombre;
  final String ? etaDescripcion;
  final EtapaRepository etapaObj = EtapaRepository();

  Etapa({  this.etaNombre, this.etaDescripcion, this.etaId});

  // Método fromJson para convertir un mapa JSON en una instancia de Etapa
  factory Etapa.fromJson(Map<String, dynamic> json) {
    return Etapa(
      etaId: json['id_etapas'] as int?, // Ajusta las claves según el JSON que recibes
      etaNombre: json['eta_nombre'] as String?,
      etaDescripcion: json['eta_descripcion'] as String?,
    );
  }
  Future<Map<String, dynamic>> etapaUpdate(int ? etaId, String ? etaNombre, String? etaDescripcion) async {
    final Map<String, dynamic> etapa = {
      'eta_nombre': etaNombre,
      'eta_descripcion': etaDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await etapaObj.updateEtapa(etaId, data);
    return status;
  
  }
  Future <Map<String, dynamic>> etapaStore(String etaNombre,String etaDescripcion) async {
    final Map<String, dynamic> etapa = {
      'eta_nombre': etaNombre,
      'eta_descripcion': etaDescripcion,
    };
    final String data = jsonEncode(etapa);
    final status = await etapaObj.createEtapas(data);
    return status;
  }
  Future<Map<String, dynamic>> etapaShow() async {
    final status = await etapaObj.getEtapaById(etaId);
    return status;
  }
  Future<List<dynamic>> etapaGet() async {
    final status = await etapaObj.getEtapa();
    return status;
  }
  Future<Map<String, dynamic>> etapaDelete(etaId) async {
    final status = await etapaObj.deleteEtapa(etaId);
    return status;
  }

}
