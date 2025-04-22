import 'dart:convert';
import 'package:http/http.dart' as http;
import 'base_url.dart';

class EtapaRepository {
  // URL base
  // Rutas específicas
  static const String urlBase = Api.urlBase;
  static final Uri etapaUrl = Uri.parse('$urlBase/api/etapas');

  // Lista de documentos
  Future<List<dynamic>> getEtapa() async {
    final response = await http.get(etapaUrl);
    final List<dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
  Future<Map<String, dynamic>> getEtapaById(int ? id) async {
    final response = await http.get(
      Uri.parse('$urlBase/api/etapas/$id'),
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> createEtapas(String data) async {
    final response = await http.post(
      etapaUrl,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> updateEtapa(int? id,String data) async {
    final response = await http.put(
      Uri.parse('$urlBase/api/etapas/$id'),
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> deleteEtapa(int? id) async {
    final response = await http.delete(
      Uri.parse('$urlBase/api/etapas/$id'),
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
}
