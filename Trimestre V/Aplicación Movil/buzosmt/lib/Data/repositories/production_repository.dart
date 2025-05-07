import 'dart:convert';
import 'package:http/http.dart' as http;
import 'base_url.dart';

class ProductionRepository {
  static const String baseUrl = Api.urlBase;

  // GET: Fetch all items
  Future<Map<String, dynamic>> getProducciones() async {
    final response = await http.get(Uri.parse('$baseUrl/producciones'));
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  // GET: Fetch a single item by ID
  Future<Map<String, dynamic>> getProdducion(int id) async {
    final response = await http.get(Uri.parse('$baseUrl/produccion/$id'));
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  // POST: Create a new item
  Future<Map<String, dynamic>> create(String data) async {
    final response = await http.post(
      Uri.parse('$baseUrl/nueva-produccion'),
      headers: {'Content-Type': 'application/json '},
      body: data
    );
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  // PUT: Update an existing item by ID
  Future<Map<String, dynamic>> update(
    int id,
    String data) async {
    final response = await http.put(
      Uri.parse('$baseUrl/produccion-editar/$id'),
      headers: {'Content-Type': 'application/json','Accept': 'application/json'},
      body: data
    );
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }

  // DELETE: Delete an item by ID
  Future<Map<String, dynamic>> delete(int id) async {
    final response = await http.delete(Uri.parse('$baseUrl/produccion-eliminar/$id'));
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
  
  Future<Map<String, dynamic>> getProduccionMateria() async {
    final response = await http.get(Uri.parse('$baseUrl/materia-prima'),
    headers: {'Content-Type': 'application/json','Accept': 'application/json'}
    );
    final status = jsonDecode(response.body);
    if (response.statusCode == 400) {
      return status;
    }
    return status;
  }
}
