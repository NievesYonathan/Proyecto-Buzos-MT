import 'package:buzosmt/Domains/models/etapa_model.dart';
import 'package:flutter/material.dart';
import 'package:buzosmt/Domains/usecases/etapas_usecase.dart';

class EtapasScreen extends StatefulWidget {
  const EtapasScreen({super.key});

  @override
  State<EtapasScreen> createState() => _EtapasScreenState();
}

class _EtapasScreenState extends State<EtapasScreen> {
  final TextEditingController nombreEtapaController = TextEditingController();
  final TextEditingController descripcionController = TextEditingController();
  // Instancia de la clase EtapasUsecase
  Map<String?, dynamic> _errors = {};
  final keyForm = GlobalKey<FormState>();

  void limpiarCampos() {
    nombreEtapaController.clear();
    descripcionController.clear();
  }

  void guardarEtapa() async {
    FocusScope.of(context).unfocus();
    if (keyForm.currentState!.validate()) {
      final EtapasUsecase validator = EtapasUsecase(
        Etapa(
          etaNombre: nombreEtapaController.text,
          etaDescripcion: descripcionController.text
        ),
      );
      final Map<String, String> errors = validator.dataValidate();
      setState(() {
        _errors = errors;
      });
      
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Etapas')),
      body: Padding(
        key: keyForm,
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            // Formulario
            TextField(
              controller: nombreEtapaController,
              decoration: const InputDecoration(
                labelText: 'Nombre de la etapa',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 16),
            TextField(
              controller: descripcionController,
              decoration: const InputDecoration(
                labelText: 'Descripción',
                border: OutlineInputBorder(),
              ),
              maxLines: 3,
            ),
            const SizedBox(height: 20),
            // Botones
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                OutlinedButton.icon(
                  onPressed: limpiarCampos,
                  icon: const Icon(Icons.clear),
                  label: const Text('Limpiar'),
                ),
                ElevatedButton.icon(
                  onPressed: guardarEtapa,
                  icon: const Icon(Icons.save),
                  label: const Text('Guardar'),
                ),
              ],
            ),
            const SizedBox(height: 20),
            // Lista de etapas
            const Divider(thickness: 1),
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 8.0),
              child: Text(
                'Lista de etapas',
                style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
