import '../../Data/repositories/user_repository.dart';

class Tdoc {
  // Objeto del login de la 
  final UserRepository apiService = UserRepository();
  
  Future<Map<int, String>> getDocumentosMap() async {
  final docs = await apiService.getDoc();

  final Map<int, String> data = {
    for (var doc in docs) doc['id_tipo_documento'] as int: doc['tip_doc_descripcion'] as String
  };

  return data;
}

}
