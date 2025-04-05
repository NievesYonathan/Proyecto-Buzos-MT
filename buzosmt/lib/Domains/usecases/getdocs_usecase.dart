import 'package:buzosmt/Data/DataSources/remote/Login_remote.dart';

class Tdoc {
  final Login apiService = Login();
  
  Future<Map<int, String>> getDocumentosMap() async {
  final docs = await apiService.getDoc();

  final Map<int, String> data = {
    for (var doc in docs) doc['id_tipo_documento'] as int: doc['tip_doc_descripcion'] as String
  };

  return data;
}

}
