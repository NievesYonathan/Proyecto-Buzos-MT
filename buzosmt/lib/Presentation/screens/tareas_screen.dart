// ignore_for_file: unnecessary_null_comparison

import 'package:flutter/material.dart';
import 'package:buzosmt/Domains/models/tarea_model.dart';

class TareasScreen extends StatelessWidget {
  const TareasScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Registrar nueva tarea'),
        elevation: 0,
        backgroundColor: const Color(0xFF0D3D4A),
        foregroundColor: Colors.white,
      ),
      backgroundColor: Colors.grey.shade100,
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
  // Definición de colores de la paleta
  final Color primaryColor = const Color(0xFF0D3D4A);
  final Color secondaryColor = const Color(0xFF20A67B);

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
          SnackBar(
            content: const Text('Tarea guardada con éxito'),
            backgroundColor: secondaryColor,
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(10),
            ),
          ),
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
        Card(
          elevation: 2,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
          child: Padding(
            padding: const EdgeInsets.all(20.0),
            child: Form(
              key: formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Información de la tarea',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: primaryColor,
                    ),
                  ),
                  const SizedBox(height: 20),
                  TextFormField(
                    controller: nombreController,
                    decoration: InputDecoration(
                      labelText: 'Nombre de la tarea',
                      labelStyle: TextStyle(color: primaryColor),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: secondaryColor, width: 2),
                      ),
                      prefixIcon: Icon(Icons.task_outlined, color: secondaryColor),
                    ),
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Por favor ingrese un nombre';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 20),
                  TextFormField(
                    controller: descripcionController,
                    decoration: InputDecoration(
                      labelText: 'Descripción',
                      labelStyle: TextStyle(color: primaryColor),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: secondaryColor, width: 2),
                      ),
                      prefixIcon: Icon(Icons.description_outlined, color: secondaryColor),
                    ),
                    maxLines: 3,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Por favor ingrese una descripción';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 30),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      OutlinedButton(
                        onPressed: () {
                          nombreController.clear();
                          descripcionController.clear();
                        },
                        style: OutlinedButton.styleFrom(
                          foregroundColor: primaryColor,
                          side: BorderSide(color: primaryColor),
                          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
                          ),
                        ),
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Icon(Icons.cleaning_services_outlined),
                            const SizedBox(width: 8),
                            Text('Limpiar'),
                          ],
                        ),
                      ),
                      const SizedBox(width: 15),
                      ElevatedButton(
                        onPressed: () => dataValidate(),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: secondaryColor,
                          foregroundColor: Colors.white,
                          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                          elevation: 3,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
                          ),
                        ),
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            const Icon(Icons.save),
                            const SizedBox(width: 8),
                            Text('Guardar'),
                          ],
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
        const SizedBox(height: 30),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Row(
              children: [
                Icon(Icons.list_alt, color: primaryColor),
                const SizedBox(width: 8),
                Text(
                  'Lista de tareas',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: primaryColor,
                  ),
                ),
              ],
            ),
            FutureBuilder<List<dynamic>>(
              future: tareasFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Container();
                } else if (snapshot.hasData) {
                  return Container(
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: secondaryColor.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      children: [
                        Icon(Icons.assignment, size: 16, color: secondaryColor),
                        const SizedBox(width: 6),
                        Text(
                          '${snapshot.data!.length} tareas',
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: secondaryColor,
                          ),
                        ),
                      ],
                    ),
                  );
                } else {
                  return Container();
                }
              },
            ),
          ],
        ),
        const SizedBox(height: 10),
        Expanded(
          child: FutureBuilder<List<dynamic>>(
            future: tareasFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return Center(
                  child: CircularProgressIndicator(color: secondaryColor),
                );
              } else if (snapshot.hasError) {
                return Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.error_outline,
                        size: 60,
                        color: Colors.red.shade300,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'Error: ${snapshot.error}',
                        style: TextStyle(color: Colors.red.shade700),
                      ),
                    ],
                  ),
                );
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.assignment_outlined,
                        size: 60,
                        color: primaryColor.withOpacity(0.3),
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'No hay tareas disponibles',
                        style: TextStyle(
                          color: primaryColor.withOpacity(0.6),
                          fontSize: 16,
                        ),
                      ),
                    ],
                  ),
                );
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
                    
                    return Padding(
                      padding: const EdgeInsets.only(bottom: 12),
                      child: Card(
                        elevation: 2,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(15),
                        ),
                        child: Padding(
                          padding: const EdgeInsets.all(16),
                          child: Row(
                            children: [
                              // Avatar con la inicial
                              Container(
                                width: 50,
                                height: 50,
                                decoration: BoxDecoration(
                                  gradient: LinearGradient(
                                    colors: [primaryColor, secondaryColor],
                                    begin: Alignment.topLeft,
                                    end: Alignment.bottomRight,
                                  ),
                                  borderRadius: BorderRadius.circular(12),
                                ),
                                child: Center(
                                  child: Text(
                                    nombre.isNotEmpty ? nombre[0].toUpperCase() : '?',
                                    style: const TextStyle(
                                      color: Colors.white,
                                      fontSize: 22,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),
                                ),
                              ),
                              const SizedBox(width: 16),
                              // Información de la tarea
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      nombre,
                                      style: const TextStyle(
                                        fontWeight: FontWeight.bold,
                                        fontSize: 16,
                                      ),
                                    ),
                                    const SizedBox(height: 4),
                                    Text(
                                      descripcion,
                                      style: TextStyle(
                                        color: Colors.grey.shade600,
                                        fontSize: 14,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              // Estado
                              if (estado.isNotEmpty)
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                                  decoration: BoxDecoration(
                                    color: secondaryColor.withOpacity(0.2),
                                    borderRadius: BorderRadius.circular(20),
                                  ),
                                  child: Text(
                                    estado,
                                    style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: secondaryColor,
                                      fontSize: 12,
                                    ),
                                  ),
                                ),
                            ],
                          ),
                        ),
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