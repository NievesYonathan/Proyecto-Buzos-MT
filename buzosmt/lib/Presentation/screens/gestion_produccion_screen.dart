import 'package:buzosmt/Domains/models/produccion_model.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:buzosmt/Domains/models/etapa_model.dart';

class GestionProduccionScreen extends StatefulWidget {
  const GestionProduccionScreen({Key? key}) : super(key: key);

  @override
  State<GestionProduccionScreen> createState() =>
      _GestionProduccionScreenState();
}

class _GestionProduccionScreenState extends State<GestionProduccionScreen> {
  final formKey = GlobalKey<FormState>();
  final TextEditingController nombreProduccionController =
      TextEditingController();
  final TextEditingController cantidadController = TextEditingController();
  final TextEditingController fechaInicioController = TextEditingController();
  final TextEditingController fechaFinController = TextEditingController();
  final Etapa etapa = Etapa();
  final Produccion produccion = Produccion();
  late Future<Map<String, dynamic>> produccionesFuture;
  List<Etapa> _etapas = [];

  int? _etapaSeleccionada;

  @override
  void initState() {
    super.initState();
    produccionesFuture = produccion.productionGet(); // Llamada a la API
    cargarEtapas();
  }

  Future<void> eliminarProduccion(dynamic item) async {
    // Obtener el ID de la etapa
    final id = item['id_produccion'];
    final nombre = item['pro_nombre'];

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
      // Ejemplo:
      final status = await produccion.productionDelete(id);

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
        produccionesFuture = produccion.productionGet();
      });
    }
  }

  void cargarEtapas() async {
    final response = await etapa.etapaGet();
    setState(() {
      _etapas = response.map<Etapa>((e) => Etapa.fromJson(e)).toList();
    });
  }

  Future<void> _selectDateInicio(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate:
          fechaInicioController.text.isNotEmpty
              ? DateFormat('dd-MM-yyyy').parse(fechaInicioController.text)
              : DateTime.now(),
      firstDate: DateTime(1920),
      lastDate: DateTime.now(),
    );

    if (picked != null) {
      setState(() {
        fechaInicioController.text = DateFormat('dd-MM-yyyy').format(picked);
      });
    }
  }

  Future<void> _selectDateFin(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate:
          fechaFinController.text.isNotEmpty
              ? DateFormat('dd-MM-yyyy').parse(fechaFinController.text)
              : DateTime.now(),
      firstDate: DateTime(1920),
      lastDate: DateTime(7000),
    );

    if (picked != null) {
      setState(() {
        fechaFinController.text = DateFormat('dd-MM-yyyy').format(picked);
      });
    }
  }

  void agregarProduccion() async {
    if (formKey.currentState!.validate()) {
      final status = await produccion.productionCreate(
        nombreProduccionController.text,
        fechaInicioController.text,
        fechaFinController.text,
        int.parse(cantidadController.text),
        _etapaSeleccionada,
      );
      if (status != null) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(status['message']),
            backgroundColor: Colors.green,
          ),
        );
      }
    }
  }

  // void eliminarProduccion(int index) {
  //   setState(() {
  //     _producciones.removeAt(index);
  //   });
  // }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Gestión de Producción')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Form(
              key: formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  TextFormField(
                    controller: nombreProduccionController,
                    decoration: const InputDecoration(
                      labelText: 'Nombre de la producción',
                    ),
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Por favor, ingrese un nombre';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: cantidadController,
                    decoration: const InputDecoration(labelText: 'Cantidad'),
                    keyboardType: TextInputType.number,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Por favor, ingrese una cantidad';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 8),
                  DropdownButtonFormField<int>(
                    // value: _etapaSeleccionada,
                    decoration: const InputDecoration(
                      labelText: 'Etapa de Producción',
                    ),
                    items:
                        _etapas.map((etapa) {
                          return DropdownMenuItem<int>(
                            value: etapa.etaId,
                            child: Text(etapa.etaNombre ?? 'Sin nombre'),
                          );
                        }).toList(),
                    onChanged: (value) {
                      setState(() {
                        _etapaSeleccionada = value!;
                      });
                    },
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: fechaInicioController,
                    readOnly: true,
                    onTap: () => _selectDateInicio(context),
                    decoration: const InputDecoration(
                      labelText: 'Fecha de inicio',
                    ),
                  ),
                  const SizedBox(height: 8),
                  TextFormField(
                    controller: fechaFinController,
                    readOnly: true,
                    onTap: () => _selectDateFin(context),
                    decoration: const InputDecoration(
                      labelText: 'Fecha de fin',
                    ),
                  ),
                  const SizedBox(height: 16),
                  ElevatedButton(
                    onPressed: agregarProduccion,
                    child: const Text('Agregar Producción'),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),
            const Text(
              'Producciones Registradas:',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 8),
            Expanded(
              child: FutureBuilder<Map<String, dynamic>>(
                future: produccionesFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return Center(
                      child: CircularProgressIndicator(color: Colors.blue),
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
                            color: Colors.blue.withOpacity(0.3),
                          ),
                          const SizedBox(height: 16),
                          Text(
                            'No hay Etapas disponibles',
                            style: TextStyle(
                              color: Colors.blue.withOpacity(0.6),
                              fontSize: 16,
                            ),
                          ),
                        ],
                      ),
                    );
                  } else {
                    final List<dynamic> etapas = snapshot.data!['producto'];

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
                              item['pro_nombre']?.toString() ??
                              item['nombre']?.toString() ??
                              'Produccion ${index + 1}';

                          // Intentar acceder a la descripción con diferentes claves posibles
                          descripcion =
                              item['pro_fecha_fin']?.toString() ??
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
                                        colors: [
                                          Colors.blue,
                                          const Color.fromARGB(
                                            255,
                                            243,
                                            33,
                                            33,
                                          ),
                                        ],
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
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
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
                                        onPressed: () {},
                                        // editarEtapa(item),
                                        tooltip: 'Editar Etapa',
                                      ),
                                      // Botón de eliminar
                                      IconButton(
                                        icon: Icon(
                                          Icons.delete,
                                          color: Colors.red,
                                        ),
                                        onPressed:
                                            () => eliminarProduccion(item),
                                        tooltip: 'eliminar Produccion',
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
        ),
      ),
    );
  }
}
