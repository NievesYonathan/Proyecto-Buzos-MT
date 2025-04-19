import 'dart:convert';
import 'package:http/http.dart' as http;

class ProductionRepository {
  final String baseUrl;

  ProductionRepository(this.baseUrl);

  // GET: Fetch all items
  Future<List<dynamic>> getAll() async {
    final response = await http.get(Uri.parse('$baseUrl/productions'));
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load productions');
    }
  }

  // GET: Fetch a single item by ID
  Future<Map<String, dynamic>> getById(String id) async {
    final response = await http.get(Uri.parse('$baseUrl/productions/$id'));
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load production');
    }
  }

  // POST: Create a new item
  Future<Map<String, dynamic>> create(Map<String, dynamic> data) async {
    final response = await http.post(
      Uri.parse('$baseUrl/productions'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode(data),
    );
    if (response.statusCode == 201) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to create production');
    }
  }

  // PUT: Update an existing item by ID
  Future<Map<String, dynamic>> update(String id, Map<String, dynamic> data) async {
    final response = await http.put(
      Uri.parse('$baseUrl/productions/$id'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode(data),
    );
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to update production');
    }
  }

  // DELETE: Delete an item by ID
  Future<void> delete(String id) async {
    final response = await http.delete(Uri.parse('$baseUrl/productions/$id'));
    if (response.statusCode != 200) {
      throw Exception('Failed to delete production');
    }
  }
}