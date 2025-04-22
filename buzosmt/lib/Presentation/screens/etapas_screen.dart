// ignore_for_file: unnecessary_null_comparison

import 'package:flutter/material.dart';
import 'package:buzosmt/Domains/models/etapa_model.dart';

class EtapasScreen extends StatelessWidget {
  const EtapasScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Registrar nueva Etapa'),
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
  final Etapa etapa = Etapa();

  late Future<List<dynamic>> etapasFuture;

  @override
  void initState() {
    super.initState();
    etapasFuture = etapa.etapaGet(); // Llamada a la API
  }

  Future<void> dataValidate() async {
    if (formKey.currentState!.validate()) {
      final status = await etapa.etapaStore(
        nombreController.text,
        descripcionController.text,
      );
      if (status != null) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(status['message']),
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
          etapasFuture = etapa.etapaGet(); // Recargar lista
        });
      }
    }
  }

  // Método para editar una etapa
  // Enfoque simplificado para el modal de edición
  Future<void> editarEtapa(dynamic item) async {
    // Obtener los datos de la etapa
    final id = item['id_etapas'] ?? item['id'];
    final nombreOriginal = item['eta_nombre'] ?? item['nombre'] ?? '';
    final descripcionOriginal =
        item['eta_descripcion'] ?? item['descripcion'] ?? '';

    // Variables para mantener los valores editados
    String nombreEditado = nombreOriginal;
    String descripcionEditada = descripcionOriginal;

    // Mostrar el diálogo modal
    await showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext dialogContext) {
        return AlertDialog(
          title: Row(
            children: [
              Icon(Icons.edit, color: secondaryColor, size: 24),
              const SizedBox(width: 10),
              Text('Editar Etapa', style: TextStyle(color: primaryColor)),
            ],
          ),
          contentPadding: const EdgeInsets.fromLTRB(24, 20, 24, 0),
          content: Container(
            width: double.maxFinite,
            child: SingleChildScrollView(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Campo de nombre
                  Text(
                    'Nombre de la Etapa',
                    style: TextStyle(
                      color: primaryColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    initialValue: nombreOriginal,
                    onChanged: (value) => nombreEditado = value,
                    decoration: InputDecoration(
                      hintText: '$id',
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 12,
                      ),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                  ),

                  const SizedBox(height: 16),

                  // Campo de descripción
                  Text(
                    'Descripción',
                    style: TextStyle(
                      color: primaryColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    initialValue: descripcionOriginal,
                    onChanged: (value) => descripcionEditada = value,
                    maxLines: 4,
                    decoration: InputDecoration(
                      hintText: 'Ingrese la descripción',
                      contentPadding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 12,
                      ),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20),
                ],
              ),
            ),
          ),
          actions: [
            OutlinedButton(
              onPressed: () => Navigator.of(dialogContext).pop(),
              style: OutlinedButton.styleFrom(
                foregroundColor: primaryColor,
                side: BorderSide(color: primaryColor),
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 10,
                ),
              ),
              child: const Text('Cancelar'),
            ),
            ElevatedButton(
              onPressed: () async {
                // Cerrar el diálogo
                Navigator.of(dialogContext).pop();

                // Aquí implementarías la llamada a la API para actualizar
                // Por ejemplo:
                final status = await etapa.etapaUpdate(
                  id,
                  nombreEditado,
                  descripcionEditada,
                );

                // Mostrar mensaje de actualización
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text(status['message']),
                    backgroundColor: Colors.orange,
                    behavior: SnackBarBehavior.floating,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                );

                // Actualizar la lista de etapas
                setState(() {
                  etapasFuture = etapa.etapaGet();
                });
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: secondaryColor,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 10,
                ),
              ),
              child: const Text('Actualizar'),
            ),
          ],
        );
      },
    );
  }

  // Método para eliminar una etapa
  Future<void> eliminarEtapa(dynamic item) async {
    // Obtener el ID de la etapa
    final id = item['id_etapas'];
    final nombre = item['eta_nombre'];

    // Mostrar diálogo de confirmación
    bool confirmar =
        await showDialog(
          context: context,
          builder:
              (context) => AlertDialog(
                title: Text('Confirmar eliminación'),
                content: Text(
                  '¿Estás seguro que deseas eliminar la Etapa "$nombre"?',
                ),
                actions: [
                  TextButton(
                    onPressed: () => Navigator.of(context).pop(false),
                    child: Text('Cancelar'),
                  ),
                  TextButton(
                    onPressed: () => Navigator.of(context).pop(true),
                    style: TextButton.styleFrom(foregroundColor: Colors.red),
                    child: Text('Eliminar'),
                  ),
                ],
              ),
        ) ??
        false;

    if (confirmar) {
      // TODO: Implementar la llamada a la API para eliminar
      // Ejemplo:
      final status = await etapa.etapaDelete(id);

      // Por ahora, simplemente mostraremos un mensaje
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(status['message']),
          backgroundColor: Colors.red.shade700,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(10),
          ),
        ),
      );

      // Actualizar lista después de eliminar
      setState(() {
        etapasFuture = etapa.etapaGet();
      });
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
                    'Información de la Etapa',
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
                      labelText: 'Nombre de la Etapa',
                      labelStyle: TextStyle(color: primaryColor),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: secondaryColor, width: 2),
                      ),
                      prefixIcon: Icon(
                        Icons.task_outlined,
                        color: secondaryColor,
                      ),
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
                      prefixIcon: Icon(
                        Icons.description_outlined,
                        color: secondaryColor,
                      ),
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
                          padding: const EdgeInsets.symmetric(
                            horizontal: 20,
                            vertical: 15,
                          ),
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
                          padding: const EdgeInsets.symmetric(
                            horizontal: 20,
                            vertical: 15,
                          ),
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
                  'Lista de Etapa',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: primaryColor,
                  ),
                ),
              ],
            ),
            FutureBuilder<List<dynamic>>(
              future: etapasFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Container();
                } else if (snapshot.hasData) {
                  return Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 12,
                      vertical: 6,
                    ),
                    decoration: BoxDecoration(
                      color: secondaryColor.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      children: [
                        Icon(Icons.assignment, size: 16, color: secondaryColor),
                        const SizedBox(width: 6),
                        Text(
                          '${snapshot.data!.length} Etapas',
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
            future: etapasFuture,
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
                        'No hay Etapas disponibles',
                        style: TextStyle(
                          color: primaryColor.withOpacity(0.6),
                          fontSize: 16,
                        ),
                      ),
                    ],
                  ),
                );
              } else {
                final List<dynamic> etapas = snapshot.data!;

                return ListView.builder(
                  itemCount: etapas.length,
                  itemBuilder: (context, index) {
                    final dynamic item = etapas[index];

                    // Acceder a los campos de manera segura

                    String nombre = '';
                    String descripcion = '';

                    if (item is Map) {
                      // Intentar acceder al nombre con diferentes claves posibles
                      nombre =
                          item['eta_nombre']?.toString() ??
                          item['nombre']?.toString() ??
                          'Etapa ${index + 1}';

                      // Intentar acceder a la descripción con diferentes claves posibles
                      descripcion =
                          item['eta_descripcion']?.toString() ??
                          item['descripcion']?.toString() ??
                          'Descripción no disponible';
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
                                    nombre.isNotEmpty
                                        ? nombre[0].toUpperCase()
                                        : '?',
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
                              // Botones de acción: Editar y Eliminar
                              Row(
                                children: [
                                  // Botón de editar
                                  IconButton(
                                    icon: Icon(
                                      Icons.edit,
                                      color: Colors.orange,
                                    ),
                                    onPressed: () => editarEtapa(item),
                                    tooltip: 'Editar Etapa',
                                  ),
                                  // Botón de eliminar
                                  IconButton(
                                    icon: Icon(Icons.delete, color: Colors.red),
                                    onPressed: () => eliminarEtapa(item),
                                    tooltip: 'Eliminar Etapa',
                                  ),
                                ],
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
