import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'base_url.dart';

class UserRepository {
  // URL base de la API
  static const String urlBase = Api.urlBase;

  // Rutas específicas
  final Uri loginUrl = Uri.parse('$urlBase/Login');
  final Uri registerUrl = Uri.parse('$urlBase/Register');
  final Uri resetPasswordUrl = Uri.parse('$urlBase/password/reset');

  // Lista de documentos
  Future<List<dynamic>> getDoc() async {
    final response = await http.get(loginUrl);
    if (response.statusCode == 400) {
      return [];
    }

    final List<dynamic> data = jsonDecode(response.body);
    return data;
  }

  Future<Map<String, dynamic>> apiLogin(String data) async {
    final response = await http.post(
      loginUrl,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    final token = status['token'] ?? '';
    final tockLocal = await SharedPreferences.getInstance();

    await tockLocal.setString('token', token);
    return status;
  }

  Future<Map<String, dynamic>> apiRegister(String data) async {
    final response = await http.post(
      registerUrl,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  Future<Map<String, dynamic>> resetPassword(String data) async {
    final response = await http.post(
      resetPasswordUrl,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
}
