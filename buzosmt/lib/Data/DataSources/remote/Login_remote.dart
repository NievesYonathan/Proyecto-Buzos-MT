import 'dart:convert';
import 'package:http/http.dart' as http;

class Login {
  // URL de la API
  final url = Uri.parse('http://127.0.0.1:8000/api/Login');

  //Lista de documentos
  Future<List<dynamic>> getDoc() async {
    final response = await http.get(url);

    if (response.statusCode == 400) {
      return [];
    }

    final List<dynamic> data = jsonDecode(response.body);
    return data;
  }

  Future<void> apiLogin(String data) async {
    final response = await http.post(
      url,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: data,
    );
    if (response.statusCode == 400) {
      print('Error en el login: ${response.body}');
    }
    print('Login exitoso: ${response.body}');
  }

  // Future<void> _loadDocs() async {
  //   final items = await apiService.getDoc();
  //   setState(() {
  //     docItems = items;
  //   });
  // }
}
