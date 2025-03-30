import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  // URL de la API
  final url = Uri.parse('http://127.0.0.1:8000/api/Login');
  //Lista de documentos
  Future<List<dynamic>> getDoc() async {
    //peticion get a la API
    final response = await http.get(url);

    if (response.statusCode == 400) {
      return []; // Retorna una lista vacía compatible
    }
    //Concertir la respuesta en formato JSON
    final List<dynamic> data = jsonDecode(response.body);
    //Retorna lista de documentos
    return data;
  }

  Future<void> apiLogin(int tDoc, int numDoc, String password) async {
    final response = await http.post(
      url,
      headers: {'Content-Type': 'application/json; charset=UTF-8'},
      body: jsonEncode({'tDoc': tDoc, 'numDoc': numDoc, 'password': password}),
    );
    if (response.statusCode == 200) {
      // print('Login exitoso');
    } else {
      // print('Login fallido');
    }
  }
}
