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
  bool _isExpanded = false;

  @override
  void initState() {
    super.initState();
    produccionesFuture = produccion.productionGet(); // Llamada a la API
    cargarEtapas();
  }

  Future<void> editarProduccion(dynamic item) async {
    // Obtener los datos de la producción
    final id = item['id_produccion'] ?? item['id'];
    final nombreOriginal = item['pro_nombre'] ?? item['nombre'] ?? '';
    final fechaInicioOriginal =
        item['pro_fecha_inicio'] ?? item['fecha_inicio'] ?? '';
    final fechaFinOriginal = item['pro_fecha_fin'] ?? item['fecha_fin'] ?? '';
    final cantidadOriginal = item['pro_cantidad'] ?? item['cantidad'] ?? '';
    final etapaOriginal = item['id_etapa'] ?? item['etapa'] ?? '';

    // Variables para mantener los valores editados
    String nombreEditado = nombreOriginal;
    String fechaInicioEditada = fechaInicioOriginal;
    String fechaFinEditada = fechaFinOriginal;
    String cantidadEditada = cantidadOriginal.toString();
    int etapaEditada = etapaOriginal is int ? etapaOriginal : int.tryParse(etapaOriginal.toString()) ?? 0;

    // Cargar las etapas antes de mostrar el diálogo
    cargarEtapas();

    // Mostrar el diálogo modal
    await showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext dialogContext) {
        return Dialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          elevation: 0,
          backgroundColor: Colors.transparent,
          child: Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  spreadRadius: 5,
                  blurRadius: 10,
                  offset: const Offset(0, 3),
                ),
              ],
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                // Encabezado del diálogo
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        color: Color(0xFF20A67B),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: const Icon(Icons.edit, color: Color(0xFF0D3D4A), size: 24),
                    ),
                    const SizedBox(width: 15),
                    const Text(
                      'Editar Producción',
                      style: TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF0D3D4A),
                      ),
                    ),
                  ],
                ),
                const Divider(height: 25, thickness: 1),
                
                // Contenido del formulario
                SingleChildScrollView(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Nombre de la Producción',
                        style: TextStyle(
                          color: Color(0xFF0D3D4A),
                          fontWeight: FontWeight.bold,
                          fontSize: 14,
                        ),
                      ),
                      const SizedBox(height: 8),
                      TextFormField(
                        initialValue: nombreOriginal,
                        onChanged: (value) => nombreEditado = value,
                        decoration: InputDecoration(
                          hintText: 'Ingrese el nombre',
                          prefixIcon: const Icon(Icons.production_quantity_limits, color: Color(0xFF0D3D4A)),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 12,
                          ),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF0D3D4A)),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                          ),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                      ),
                      const SizedBox(height: 16),

                      const Text(
                        'Cantidad',
                        style: TextStyle(
                          color: Color(0xFF0D3D4A),
                          fontWeight: FontWeight.bold,
                          fontSize: 14,
                        ),
                      ),
                      const SizedBox(height: 8),
                      TextFormField(
                        initialValue: cantidadOriginal.toString(),
                        keyboardType: TextInputType.number,
                        onChanged: (value) => cantidadEditada = value,
                        decoration: InputDecoration(
                          hintText: 'Ingrese la cantidad',
                          prefixIcon: const Icon(Icons.format_list_numbered, color: Color(0xFF20A67B)),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 12,
                          ),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF0D3D4A)),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                          ),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                      ),
                      const SizedBox(height: 16),

                      const Text(
                        'Etapa',
                        style: TextStyle(
                          color: Color(0xFF0D3D4A),
                          fontWeight: FontWeight.bold,
                          fontSize: 14,
                        ),
                      ),
                      const SizedBox(height: 8),
                      DropdownButtonFormField<int>(
                        value: _etapas.any((etapa) => etapa.etaId == etapaEditada) ? etapaEditada : null,
                        decoration: InputDecoration(
                          prefixIcon: const Icon(Icons.layers, color: Color(0xFF20A67B)),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 12,
                          ),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF0D3D4A)),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                          ),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                        items: _etapas.map((etapa) {
                          return DropdownMenuItem<int>(
                            value: etapa.etaId,
                            child: Text(etapa.etaNombre ?? 'Sin nombre'),
                          );
                        }).toList(),
                        onChanged: (value) {
                          etapaEditada = value!;
                        },
                      ),
                      const SizedBox(height: 16),

                      const Text(
                        'Fecha de Fin',
                        style: TextStyle(
                          color: Color(0xFF0D3D4A),
                          fontWeight: FontWeight.bold,
                          fontSize: 14,
                        ),
                      ),
                      const SizedBox(height: 8),
                      TextFormField(
                        initialValue: fechaFinOriginal,
                        readOnly: true,
                        onTap: () => _selectDateFin(context),
                        decoration: InputDecoration(
                          hintText: 'Seleccione la fecha de fin',
                          prefixIcon: const Icon(Icons.calendar_today, color: Color(0xFF0D3D4A)),
                          contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16,
                            vertical: 12,
                          ),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Color(0xFF0D3D4A)),
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(15),
                            borderSide: const BorderSide(color: Colors.orange, width: 2),
                          ),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 20),
                
                // Botones de acción
                Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    OutlinedButton(
                      onPressed: () => Navigator.of(dialogContext).pop(),
                      style: OutlinedButton.styleFrom(
                        foregroundColor: Color(0xFF0D3D4A),
                        side: const BorderSide(color: Color(0xFF0D3D4A)),
                        padding: const EdgeInsets.symmetric(
                          horizontal: 16,
                          vertical: 12,
                        ),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(30),
                        ),
                      ),
                      child: const Text('Cancelar'),
                    ),
                    const SizedBox(width: 12),
                    ElevatedButton(
                      onPressed: () async {
                        // Cerrar el diálogo
                        Navigator.of(dialogContext).pop();

                        // Llamada a la API para actualizar
                        final status = await produccion.productionUpdate(
                          id,
                          nombreEditado,
                          fechaFinEditada,
                          int.parse(cantidadEditada),
                          etapaEditada,
                        );

                        // Mostrar mensaje de actualización
                        if (!context.mounted) return;
                        ScaffoldMessenger.of(context).showSnackBar(
                          SnackBar(
                            content: Text(
                              status['message'] ?? 'Producción actualizada con éxito',
                            ),
                            backgroundColor: Color(0xFF20A67B),
                            behavior: SnackBarBehavior.floating,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10),
                            ),
                            action: SnackBarAction(
                              label: 'OK',
                              textColor: Colors.white,
                              onPressed: () {},
                            ),
                          ),
                        );

                        // Actualizar la lista de producciones
                        setState(() {
                          produccionesFuture = produccion.productionGet();
                        });
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Color(0xFF20A67B),
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(
                          horizontal: 20,
                          vertical: 12,
                        ),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(30),
                        ),
                        elevation: 5,
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Icon(Icons.check, size: 18),
                          SizedBox(width: 8),
                          Text('Actualizar'),
                        ],
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  Future<void> eliminarProduccion(dynamic item) async {
    // Obtener el ID de la producción
    final id = item['id_produccion'];
    final nombre = item['pro_nombre'];

    // Mostrar diálogo de confirmación
    bool confirmar = await showDialog(
      context: context,
      builder: (context) => Dialog(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20),
        ),
        elevation: 0,
        backgroundColor: Colors.transparent,
        child: Container(
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.1),
                spreadRadius: 5,
                blurRadius: 10,
                offset: const Offset(0, 3),
              ),
            ],
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                padding: const EdgeInsets.all(15),
                decoration: BoxDecoration(
                  color: Colors.red.shade50,
                  shape: BoxShape.circle,
                ),
                child: Icon(
                  Icons.delete_forever,
                  color: Colors.red.shade700,
                  size: 30,
                ),
              ),
              const SizedBox(height: 15),
              Text(
                'Confirmar eliminación',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Colors.red.shade700,
                ),
              ),
              const SizedBox(height: 10),
              Text(
                '¿Estás seguro que deseas eliminar la Producción "$nombre"?',
                textAlign: TextAlign.center,
                style: const TextStyle(
                  fontSize: 16,
                  color: Colors.black87,
                ),
              ),
              const SizedBox(height: 20),
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  OutlinedButton(
                    onPressed: () => Navigator.of(context).pop(false),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: Colors.grey.shade800,
                      side: BorderSide(color: Colors.grey.shade300),
                      padding: const EdgeInsets.symmetric(
                        horizontal: 20,
                        vertical: 12,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(30),
                      ),
                    ),
                    child: const Text('Cancelar'),
                  ),
                  const SizedBox(width: 15),
                  ElevatedButton(
                    onPressed: () => Navigator.of(context).pop(true),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.red.shade600,
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(
                        horizontal: 20,
                        vertical: 12,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(30),
                      ),
                      elevation: 5,
                    ),
                    child: const Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.delete_outline, size: 18),
                        SizedBox(width: 8),
                        Text('Eliminar'),
                      ],
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    ) ?? false;

    if (confirmar) {
      final status = await produccion.productionDelete(id);

      // Mostrar mensaje de eliminación
      if (!context.mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Row(
            children: [
              const Icon(Icons.delete_forever, color: Colors.white),
              const SizedBox(width: 16),
              Expanded(child: Text(status['message'])),
            ],
          ),
          backgroundColor: Colors.red.shade700,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(10),
          ),
          duration: const Duration(seconds: 3),
          action: SnackBarAction(
            label: 'OK',
            textColor: Colors.white,
            onPressed: () {},
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
      builder: (context, child) {
        return Theme(
          data: Theme.of(context).copyWith(
            colorScheme: const ColorScheme.light(
              primary: Color(0xFF0D3D4A),
              onPrimary: Colors.white,
              surface: Colors.white,
              onSurface: Colors.black,
            ),
            dialogBackgroundColor: Colors.white,
          ),
          child: child!,
        );
      },
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
      builder: (context, child) {
        return Theme(
          data: Theme.of(context).copyWith(
            colorScheme: const ColorScheme.light(
              primary: Color(0xFF0D3D4A),
              onPrimary: Colors.white,
              surface: Colors.white,
              onSurface: Colors.black,
            ),
            dialogBackgroundColor: Colors.white,
          ),
          child: child!,
        );
      },
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
            content: Row(
              children: [
                const Icon(Icons.check_circle, color: Colors.white),
                const SizedBox(width: 16),
                Expanded(child: Text(status['message'])),
              ],
            ),
            backgroundColor: Colors.green,
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(10),
            ),
            action: SnackBarAction(
              label: 'OK',
              textColor: Colors.white,
              onPressed: () {},
            ),
          ),
        );
        
        // Limpiar formulario
        nombreProduccionController.clear();
        cantidadController.clear();
        fechaInicioController.clear();
        fechaFinController.clear();
        setState(() {
          _etapaSeleccionada = null;
          produccionesFuture = produccion.productionGet();
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey.shade100,
      appBar: AppBar(
        title: const Text(
          'Gestión de Producción',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        centerTitle: true,
        backgroundColor: Color(0xFF0D3D4A),
        foregroundColor: Colors.white,
        elevation: 0,
        shape: const RoundedRectangleBorder(
        ),
        actions: [
          IconButton(
            icon: Icon(_isExpanded ? Icons.expand_less : Icons.expand_more),
            onPressed: () {
              setState(() {
                _isExpanded = !_isExpanded;
              });
            },
            tooltip: _isExpanded ? 'Contraer' : 'Expandir',
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Formulario
            AnimatedCrossFade(
              firstChild: Container(
                padding: const EdgeInsets.all(20),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [
                    BoxShadow(
                      color: Color.fromARGB(25, 13, 61, 74),
                      blurRadius: 10,
                      spreadRadius: 2,
                      offset: const Offset(0, 2),
                    ),
                  ],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(10),
                          decoration: BoxDecoration(
                            color: Color(0xFF0D3D4A),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Icon(
                            Icons.add_circle_outline,
                            color: Color(0xFF20A67B),
                            size: 24,
                          ),
                        ),
                        const SizedBox(width: 12),
                        const Text(
                          'Nueva Producción',
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: Color(0xFF0D3D4A),
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 20),
                    Form(
                      key: formKey,
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          TextFormField(
                            controller: nombreProduccionController,
                            decoration: InputDecoration(
                              labelText: 'Nombre de la producción',
                              labelStyle: TextStyle(color: Color(0xFF0D3D4A)),
                              prefixIcon: const Icon(Icons.production_quantity_limits, color: Color(0xFF0D3D4A)),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                                borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                              ),
                              filled: true,
                              fillColor: Colors.grey.shade50,
                            ),
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor, ingrese un nombre';
                              }
                              return null;
                            },
                          ),
                          const SizedBox(height: 15),
                          TextFormField(
                            controller: cantidadController,
                            decoration: InputDecoration(
                              labelText: 'Cantidad',
                              labelStyle: TextStyle(color: Color(0xFF0D3D4A)),
                              prefixIcon: const Icon(Icons.format_list_numbered, color: Color(0xFF0D3D4A)),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                                borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                              ),
                              filled: true,
                              fillColor: Colors.grey.shade50,
                            ),
                            keyboardType: TextInputType.number,
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor, ingrese una cantidad';
                              }
                              return null;
                            },
                          ),
                          const SizedBox(height: 15),
                          DropdownButtonFormField<int>(
                            decoration: InputDecoration(
                              labelText: 'Etapa de Producción',
                              labelStyle: TextStyle(color: Color(0xFF0D3D4A)),
                              prefixIcon: const Icon(Icons.layers, color: Color(0xFF0D3D4A)),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(15),
                                borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                              ),
                              filled: true,
                              fillColor: Colors.grey.shade50,
                            ),
                            items: _etapas.map((etapa) {
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
                            validator: (value) {
                              if (value == null) {
                                return 'Por favor, seleccione una etapa';
                              }
                              return null;
                            },
                          ),
                          const SizedBox(height: 15),
                          Row(
                            children: [
                              Expanded(
                                child: TextFormField(
                                  controller: fechaInicioController,
                                  readOnly: true,
                                  onTap: () => _selectDateInicio(context),
                                  decoration: InputDecoration(
                                    labelText: 'Fecha de inicio',
                                    labelStyle: TextStyle(color: Color(0xFF0D3D4A)),
                                    prefixIcon: const Icon(Icons.calendar_today, color: Color(0xFF0D3D4A)),
                                    border: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    focusedBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(15),
                                      borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                                    ),
                                    filled: true,
                                    fillColor: Colors.grey.shade50,
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Por favor, seleccione una fecha';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                              const SizedBox(width: 15),
                              Expanded(
                                child: TextFormField(
                                  controller: fechaFinController,
                                  readOnly: true,
                                  onTap: () => _selectDateFin(context),
                                  decoration: InputDecoration(
                                    labelText: 'Fecha de fin',
                                    labelStyle: TextStyle(color: Color(0xFF0D3D4A)),
                                    prefixIcon: const Icon(Icons.event, color: Color(0xFF0D3D4A)),
                                    border: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    focusedBorder: OutlineInputBorder(
                                      borderRadius: BorderRadius.circular(15),
                                      borderSide: const BorderSide(color: Color(0xFF20A67B), width: 2),
                                    ),
                                    filled: true,
                                    fillColor: Colors.grey.shade50,
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Por favor, seleccione una fecha';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 25),
                          SizedBox(
                            width: double.infinity,
                            height: 50,
                            child: ElevatedButton(
                              onPressed: agregarProduccion,
                              style: ElevatedButton.styleFrom(
                                backgroundColor: Color(0xFF0D3D4A),
                                foregroundColor: Colors.white,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(15),
                                ),
                                elevation: 5,
                              ),
                              child: const Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Icon(Icons.add),
                                  SizedBox(width: 10),
                                  Text(
                                    'Agregar Producción',
                                    style: TextStyle(
                                      fontSize: 16,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              secondChild: Container(
                padding: const EdgeInsets.all(15),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [
                    BoxShadow(
                      color: Color.fromARGB(21, 13, 61, 74),
                      blurRadius: 20,
                      spreadRadius: 2,
                      offset: const Offset(0, 2),
                    ),
                  ],
                ),
                child: Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(10),
                      decoration: BoxDecoration(
                        color: Color(0xFF20A67B),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: const Icon(
                        Icons.add_circle_outline,
                        color: Color(0xFF0D3D4A),
                        size: 24,
                      ),
                    ),
                    const SizedBox(width: 12),
                    const Text(
                      'Nueva Producción',
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF0D3D4A),
                      ),
                    ),
                    const Spacer(),
                    IconButton(
                      icon: const Icon(Icons.arrow_downward, color: Color(0xFF0D3D4A)),
                      onPressed: () {
                        setState(() {
                          _isExpanded = true;
                        });
                      },
                      tooltip: 'Mostrar formulario',
                    ),
                  ],
                ),
              ),
              crossFadeState: _isExpanded
                  ? CrossFadeState.showFirst
                  : CrossFadeState.showSecond,
              duration: const Duration(milliseconds: 300),
            ),
            
            const SizedBox(height: 20),
            
            // Título de la sección de listado
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(15),
                boxShadow: [
                  BoxShadow(
                    color: Color.fromARGB(25, 13, 61, 74),
                    blurRadius: 5,
                    spreadRadius: 1,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: Color(0xFF20A67B),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: const Icon(Icons.list_alt, color: Color(0xFF0D3D4A)),
                  ),
                  const SizedBox(width: 12),
                  const Text(
                    'Producciones Registradas',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF0D3D4A),
                    ),
                  ),
                  const Spacer(),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                    decoration: BoxDecoration(
                      color: Color(0xFF0D3D4A),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const Icon(Icons.refresh, color: Color.fromARGB(255, 255, 255, 255), size: 16),
                        const SizedBox(width: 5),
                        Text(
                          'Actualizar',
                          style: TextStyle(
                            fontSize: 12,
                            color: Color.fromARGB(255, 255, 255, 255),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            
            const SizedBox(height: 16),
            
            // Lista de producciones
            Expanded(
              child: FutureBuilder<Map<String, dynamic>>(
                future: produccionesFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          const CircularProgressIndicator(
                            color: Color(0xFF0D3D4A),
                            strokeWidth: 3,
                          ),
                          const SizedBox(height: 20),
                          Text(
                            'Cargando producciones...',
                            style: TextStyle(
                              color: Color(0xFF0D3D4A),
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ],
                      ),
                    );
                  } else if (snapshot.hasError) {
                    return Center(
                      child: Container(
                        padding: const EdgeInsets.all(20),
                        decoration: BoxDecoration(
                          color: Colors.red.shade50,
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.red.shade100.withOpacity(0.5),
                              blurRadius: 10,
                              spreadRadius: 5,
                            ),
                          ],
                        ),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
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
                              style: TextStyle(
                                color: Colors.red.shade700,
                                fontWeight: FontWeight.w500,
                                fontSize: 16,
                              ),
                              textAlign: TextAlign.center,
                            ),
                            const SizedBox(height: 16),
                            ElevatedButton.icon(
                              icon: const Icon(Icons.refresh),
                              label: const Text('Reintentar'),
                              onPressed: () {
                                setState(() {
                                  produccionesFuture = produccion.productionGet();
                                });
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: Colors.red.shade100,
                                foregroundColor: Colors.red.shade700,
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 20,
                                  vertical: 12,
                                ),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(15),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    );
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return Center(
                      child: Container(
                        padding: const EdgeInsets.all(25),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: Color(0xFF0D3D4A),
                              blurRadius: 10,
                              spreadRadius: 5,
                            ),
                          ],
                        ),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(
                              Icons.assignment_outlined,
                              size: 70,
                              color: Color.fromARGB(47, 13, 61, 74),
                            ),
                            const SizedBox(height: 20),
                            Text(
                              'No hay Producciones disponibles',
                              style: TextStyle(
                                color: Color.fromARGB(49, 13, 61, 74),
                                fontSize: 18,
                                fontWeight: FontWeight.w500,
                              ),
                              textAlign: TextAlign.center,
                            ),
                            const SizedBox(height: 10),
                            Text(
                              'Agrega una nueva producción para comenzar',
                              style: TextStyle(
                                color: Colors.grey.shade600,
                                fontSize: 14,
                              ),
                              textAlign: TextAlign.center,
                            ),
                            const SizedBox(height: 20),
                            ElevatedButton.icon(
                              icon: const Icon(Icons.add_circle_outline),
                              label: const Text('Agregar Producción'),
                              onPressed: () {
                                setState(() {
                                  _isExpanded = true;
                                });
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: Color(0xFF0D3D4A),
                                foregroundColor: Colors.white,
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 20,
                                  vertical: 12,
                                ),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(15),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    );
                  } else {
                    final List<dynamic> producciones = snapshot.data!['producto'];

                    return ListView.builder(
                      itemCount: producciones.length,
                      itemBuilder: (context, index) {
                        final dynamic item = producciones[index];

                        // Acceder a los campos de manera segura
                        String nombre = '';
                        String fechaFin = '';
                        String cantidad = '';
                        String etapaId = '';

                        if (item is Map) {
                          // Intentar acceder al nombre con diferentes claves posibles
                          nombre =
                              item['pro_nombre']?.toString() ??
                              item['nombre']?.toString() ??
                              'Produccion ${index + 1}';

                          // Intentar acceder a la fecha de fin
                          fechaFin =
                              item['pro_fecha_fin']?.toString() ??
                              item['fecha_fin']?.toString() ??
                              'Fecha no disponible';
                              
                          // Cantidad
                          cantidad =
                              item['pro_cantidad']?.toString() ??
                              item['cantidad']?.toString() ??
                              '0';
                              
                          // Etapa ID
                          etapaId =
                              item['id_etapa']?.toString() ??
                              item['etapa']?.toString() ??
                              '';
                        }

                        // Nombre de la etapa
                        String nombreEtapa = 'Sin etapa';
                        if (etapaId.isNotEmpty) {
                          int? id = int.tryParse(etapaId);
                          if (id != null) {
                            final etapaEncontrada = _etapas.firstWhere(
                              (etapa) => etapa.etaId == id,
                              orElse: () => Etapa(),
                            );
                            nombreEtapa = etapaEncontrada.etaNombre ?? 'Sin nombre';
                          }
                        }

                        return Padding(
                          padding: const EdgeInsets.only(bottom: 15),
                          child: Container(
                            decoration: BoxDecoration(
                              color: Colors.white,
                              borderRadius: BorderRadius.circular(20),
                              boxShadow: [
                                BoxShadow(
                                  color: Color.fromARGB(42, 13, 61, 74),
                                  blurRadius: 10,
                                  spreadRadius: 1,
                                  offset: const Offset(0, 2),
                                ),
                              ],
                            ),
                            child: Column(
                              children: [
                                Padding(
                                  padding: const EdgeInsets.all(16),
                                  child: Row(
                                    children: [
                                      // Avatar con la inicial
                                      Container(
                                        width: 55,
                                        height: 55,
                                        decoration: BoxDecoration(
                                          gradient: LinearGradient(
                                            colors: [
                                               Color(0xFF0D3D4A),
                                              Color(0xFF20A67B),
                                            ],
                                            begin: Alignment.topLeft,
                                            end: Alignment.bottomRight,
                                          ),
                                          borderRadius: BorderRadius.circular(15),
                                          boxShadow: [
                                            BoxShadow(
                                              color: Color.fromARGB(59, 32, 166, 124),
                                              blurRadius: 8,
                                              spreadRadius: 1,
                                              offset: const Offset(0, 3),
                                            ),
                                          ],
                                        ),
                                        child: Center(
                                          child: Text(
                                            nombre.isNotEmpty
                                                ? nombre[0].toUpperCase()
                                                : '?',
                                            style: const TextStyle(
                                              color: Colors.white,
                                              fontSize: 24,
                                              fontWeight: FontWeight.bold,
                                            ),
                                          ),
                                        ),
                                      ),
                                      const SizedBox(width: 16),
                                      // Información de la producción
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment:
                                              CrossAxisAlignment.start,
                                          children: [
                                            Text(
                                              nombre,
                                              style: const TextStyle(
                                                fontWeight: FontWeight.bold,
                                                fontSize: 18,
                                                color: Colors.black87,
                                              ),
                                            ),
                                            const SizedBox(height: 6),
                                            Row(
                                              children: [
                                                Container(
                                                  padding: const EdgeInsets.symmetric(
                                                    horizontal: 8,
                                                    vertical: 4,
                                                  ),
                                                  decoration: BoxDecoration(
                                                    color: Colors.blue.withOpacity(0.1),
                                                    borderRadius: BorderRadius.circular(20),
                                                  ),
                                                  child: Row(
                                                    mainAxisSize: MainAxisSize.min,
                                                    children: [
                                                      const Icon(
                                                        Icons.layers,
                                                        size: 14,
                                                        color: Colors.blue,
                                                      ),
                                                      const SizedBox(width: 5),
                                                      Text(
                                                        nombreEtapa,
                                                        style: TextStyle(
                                                          color: Colors.blue.shade700,
                                                          fontSize: 12,
                                                          fontWeight: FontWeight.w500,
                                                        ),
                                                      ),
                                                    ],
                                                  ),
                                                ),
                                                const SizedBox(width: 10),
                                                Container(
                                                  padding: const EdgeInsets.symmetric(
                                                    horizontal: 8,
                                                    vertical: 4,
                                                  ),
                                                  decoration: BoxDecoration(
                                                    color: Color.fromARGB(44, 32, 166, 124),
                                                    borderRadius: BorderRadius.circular(20),
                                                  ),
                                                  child: Row(
                                                    mainAxisSize: MainAxisSize.min,
                                                    children: [
                                                      const Icon(
                                                        Icons.format_list_numbered,
                                                        size: 14,
                                                        color: Color(0xFF20A67B)
                                                      ),
                                                      const SizedBox(width: 5),
                                                      Text(
                                                        '$cantidad unidades',
                                                        style: TextStyle(
                                                          color: Color(0xFF20A67B),
                                                          fontSize: 12,
                                                          fontWeight: FontWeight.w500,
                                                        ),
                                                      ),
                                                    ],
                                                  ),
                                                ),
                                              ],
                                            ),
                                            const SizedBox(height: 6),
                                            Row(
                                              children: [
                                                const Icon(
                                                  Icons.event,
                                                  size: 14,
                                                  color: Colors.grey,
                                                ),
                                                const SizedBox(width: 5),
                                                Text(
                                                  'Fecha de fin: $fechaFin',
                                                  style: TextStyle(
                                                    color: Colors.grey.shade600,
                                                    fontSize: 13,
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                                // Botones de acción
                                Container(
                                  decoration: BoxDecoration(
                                    color: Colors.grey.shade50,
                                    borderRadius: const BorderRadius.vertical(
                                      bottom: Radius.circular(20),
                                    ),
                                  ),
                                  child: Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                                    children: [
                                      // Botón de editar
                                      Expanded(
                                        child: TextButton.icon(
                                          icon: const Icon(
                                            Icons.edit,
                                            color: Colors.orange,
                                            size: 20,
                                          ),
                                          label: const Text(
                                            'Editar',
                                            style: TextStyle(
                                              color: Colors.orange,
                                              fontWeight: FontWeight.w500,
                                            ),
                                          ),
                                          onPressed: () => editarProduccion(item),
                                          style: TextButton.styleFrom(
                                            foregroundColor: Colors.orange,
                                            padding: const EdgeInsets.symmetric(vertical: 12),
                                            shape: const RoundedRectangleBorder(
                                              borderRadius: BorderRadius.vertical(
                                                bottom: Radius.circular(0),
                                              ),
                                            ),
                                          ),
                                        ),
                                      ),
                                      const VerticalDivider(
                                        width: 1,
                                        thickness: 1,
                                        color: Colors.grey,
                                      ),
                                      // Botón de eliminar
                                      Expanded(
                                        child: TextButton.icon(
                                          icon: const Icon(
                                            Icons.delete,
                                            color: Colors.red,
                                            size: 20,
                                          ),
                                          label: const Text(
                                            'Eliminar',
                                            style: TextStyle(
                                              color: Colors.red,
                                              fontWeight: FontWeight.w500,
                                            ),
                                          ),
                                          onPressed: () => eliminarProduccion(item),
                                          style: TextButton.styleFrom(
                                            foregroundColor: Colors.red,
                                            padding: const EdgeInsets.symmetric(vertical: 12),
                                            shape: const RoundedRectangleBorder(
                                              borderRadius: BorderRadius.vertical(
                                                bottom: Radius.circular(0),
                                              ),
                                            ),
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              ],
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
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          setState(() {
            _isExpanded = true;
            produccionesFuture = produccion.productionGet();
          });
        },
        backgroundColor: Color(0xFF064c41),
        foregroundColor: Color(0xFF20A67B),
        elevation: 5,
        tooltip: 'Refrescar lista',
        child: const Icon(Icons.refresh),
      ),
    );
  }
}