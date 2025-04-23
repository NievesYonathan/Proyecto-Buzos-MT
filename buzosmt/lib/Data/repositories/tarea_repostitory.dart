import 'dart:convert';
import 'package:http/http.dart' as http;
import 'base_url.dart';

class EtapaRepository {
  // URL base
  // Rutas específicas
  static const String urlBase = Api.urlBase;
  static final Uri tareaUrl = Uri.parse('$urlBase/api/tareas');

  // Lista de documentos
  Future<List<dynamic>> getTarea() async {
    final response = await http.get(tareaUrl);
    final List<dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }

    return status;
  }

  Future<Map<String, dynamic>> getTareaById(int? id) async {
    final response = await http.get(
      Uri.parse('$urlBase/tareas/$id'),
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> createTarea(String data) async {
    final response = await http.post(
      tareaUrl,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> updateTarea(int? id, String data) async {
    final response = await http.put(
      Uri.parse('$urlBase/tareas/$id'),
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
}
