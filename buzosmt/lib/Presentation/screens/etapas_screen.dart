import 'package:flutter/material.dart';

class EtapasScreen extends StatefulWidget {
  const EtapasScreen({super.key});

  @override
  State<EtapasScreen> createState() => _EtapasScreenState();
}

class _EtapasScreenState extends State<EtapasScreen> {
  final TextEditingController nombreController = TextEditingController();
  final TextEditingController descripcionController = TextEditingController();

  void limpiarCampos() {
    nombreController.clear();
    descripcionController.clear();
  }

  void guardarEtapa() {
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Registrar Etapa'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            // Formulario
            TextField(
              controller: nombreController,
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