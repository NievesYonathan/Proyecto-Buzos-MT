import 'package:flutter/material.dart';
import 'package:buzosmt/Domains/models/tarea_model.dart';

class TareasScreen extends StatelessWidget {
  const TareasScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Registrar nueva tarea')),
      body: const Padding(
        padding: EdgeInsets.all(16.0),
        child: FormularioTarea(),
      ),
    );
  }
}

class FormularioTarea extends StatefulWidget {
  const FormularioTarea({super.key});

  @override
  State<FormularioTarea> createState() => _FormularioTareaState();
}

class _FormularioTareaState extends State<FormularioTarea> {
  final TextEditingController nombreController = TextEditingController();
  final TextEditingController descripcionController = TextEditingController();
  final GlobalKey<FormState> formKey = GlobalKey<FormState>();
  final Tarea tarea = Tarea();

  late Future<List<dynamic>> tareasFuture;

  @override
  void initState() {
    super.initState();
    tareasFuture = tarea.tareaGet(); // Llamada a la API
  }

  Future<void> dataValidate() async {
    if (formKey.currentState!.validate()) {
      final status = await tarea.tareaStore(
        nombreController.text,
        descripcionController.text,
      );
      if (status != null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Tarea guardada')),
        );
        nombreController.clear();
        descripcionController.clear();
        setState(() {
          tareasFuture = tarea.tareaGet(); // Recargar lista
        });
      }
    }
  }

  @override
  void dispose() {
    nombreController.dispose();
    descripcionController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Form(
          key: formKey,
          child: Column(
            children: [
              TextFormField(
                controller: nombreController,
                decoration: const InputDecoration(labelText: 'Nombre de la tarea'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese un nombre';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 10),
              TextFormField(
                controller: descripcionController,
                decoration: const InputDecoration(labelText: 'Descripción'),
                maxLines: 3,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese una descripción';
                  }
                  return null;
                },
              ),
            ],
          ),
        ),
        const SizedBox(height: 20),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            ElevatedButton(
              onPressed: () {
                nombreController.clear();
                descripcionController.clear();
              },
              child: const Text('LIMPIAR'),
            ),
            const SizedBox(width: 10),
            ElevatedButton(
              onPressed: () => dataValidate(),
              child: const Text('GUARDAR'),
            ),
          ],
        ),
        const SizedBox(height: 40),
        const Align(
          alignment: Alignment.centerLeft,
          child: Text(
            'Lista de tareas',
            style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
          ),
        ),
        const SizedBox(height: 10),
        Expanded(
          child: FutureBuilder<List<dynamic>>(
            future: tareasFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Center(child: CircularProgressIndicator());
              } else if (snapshot.hasError) {
                return Center(child: Text('Error: ${snapshot.error}'));
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return const Center(child: Text('No hay tareas disponibles'));
              } else {
                final List<dynamic> tareas = snapshot.data!;
                
                return ListView.builder(
                  itemCount: tareas.length,
                  itemBuilder: (context, index) {
                    final dynamic item = tareas[index];
                    
                    // Acceder a los campos de manera segura
                    String nombre = '';
                    String descripcion = '';
                    String estado = '';
                    
                    if (item is Map) {
                      // Intentar acceder al nombre con diferentes claves posibles
                      nombre = item['tar_nombre']?.toString() ?? 
                              item['nombre']?.toString() ?? 
                              'Tarea ${index + 1}';
                              
                      // Intentar acceder a la descripción con diferentes claves posibles
                      descripcion = item['tar_descripcion']?.toString() ?? 
                                   item['descripcion']?.toString() ?? 
                                   'Sin descripción';
                                   
                      // Intentar acceder al estado
                      if (item['estados'] is Map) {
                        estado = item['estados']['nombre_estado']?.toString() ?? '';
                      } else {
                        estado = item['estado']?.toString() ?? '';
                      }
                    }
                    
                    return Card(
                      margin: const EdgeInsets.symmetric(vertical: 4, horizontal: 2),
                      child: ListTile(
                        title: Text(nombre),
                        subtitle: Text(descripcion),
                        trailing: estado.isNotEmpty ? Text(estado) : null,
                      ),
                    );
                  },
                );
              }
            },
          ),
        ),
      ],
    );
  }
}