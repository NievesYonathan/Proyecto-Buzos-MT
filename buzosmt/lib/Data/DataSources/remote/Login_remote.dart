import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class Login {
  // URL de la API
  final url = Uri.parse('http://192.168.80.16:8000/api/Login');

  //Lista de documentos
  Future<List<dynamic>> getDoc() async {
    final response = await http.get(url);

    if (response.statusCode == 400) {
      return [];
    }

    final List<dynamic> data = jsonDecode(response.body);
    return data;
  }

  Future<Map<String, dynamic>> apiLogin(String data) async {
    final response = await http.post(
      url,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    final Map<String, dynamic> status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      // print(status);
      return status;
    }
    final token = status['token'] ?? '';
    final tockLocal = await SharedPreferences.getInstance();

    await tockLocal.setString('token', token);
    return status;
  }
}
