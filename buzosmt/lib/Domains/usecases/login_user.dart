import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  final url = Uri.parse('http://127.0.0.1:8000/api/login');
  Future<List<String>> getDoc() async {
    final response = await http.get(url);
    if(response.statusCode == 400) {
      return [];
    }
    final List<String> data = jsonDecode(response.body);
      return data.map((e) => e.toString()).toList();
  }

  Future<void> apiLogin(int tDoc, int numDoc, String password) async {
    final response = await http.post(
      url,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: jsonEncode({'tDoc': tDoc, 'numDoc': numDoc, 'password': password}),
    );
    if (response.statusCode == 200) {
      print('Login exitoso');
    } else {
      print('Login fallido');
    }
  }
}
