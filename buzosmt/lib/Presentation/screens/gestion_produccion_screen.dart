<<<<<<< HEAD
import 'package:flutter/material.dart';
import 'dart:io';
import 'package:image_picker/image_picker.dart';
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'package:flutter/foundation.dart' show kIsWeb;
import 'package:buzosmt/Domains/models/produccion_model.dart';

class GestionProduccionScreen extends StatefulWidget {
  const GestionProduccionScreen({Key? key}) : super(key: key);

  @override
  State<GestionProduccionScreen> createState() => _GestionProduccionScreenState();
}

class _GestionProduccionScreenState extends State<GestionProduccionScreen> {
  // Color scheme
  final Color primaryColor = const Color(0xFF0D3D4A);
  final Color secondaryColor = const Color(0xFF20A67B);

  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nombreController = TextEditingController();
  final TextEditingController _cantidadController = TextEditingController();
  
  DateTime _fechaInicio = DateTime.now();
  DateTime _fechaFin = DateTime.now().add(const Duration(days: 7));
  String _etapaSeleccionada = 'Planificación';
  String? _imagenPath;
  Uint8List? _webImage;
  bool _imagenSeleccionada = false;
  
  List<ProduccionModel> _producciones = [];
  bool _estaCargando = false;
  bool _modoEdicion = false;
  int _indiceEdicion = -1;
  
  final List<String> _etapasProduccion = [
    'Planificación',
    'Preparación',
    'Fabricación',
    'Control de Calidad',
    'Empaquetado',
    'Distribución',
    'Finalizado'
  ];

  @override
  void initState() {
    super.initState();
    // Cargar datos de ejemplo
    _cargarDatosEjemplo();
  }

  void _cargarDatosEjemplo() {
    _producciones = [
      ProduccionModel(
        proNombre: "Producción Lote A-123",
        proFechaInicio: DateTime.now().subtract(const Duration(days: 5)),
        proFechaFin: DateTime.now().add(const Duration(days: 10)),
        proCantidad: 500,
        proEtapa: "Fabricación",
      ),
      ProduccionModel(
        proNombre: "Producción Lote B-456",
        proFechaInicio: DateTime.now().subtract(const Duration(days: 2)),
        proFechaFin: DateTime.now().add(const Duration(days: 15)),
        proCantidad: 300,
        proEtapa: "Preparación",
      ),
      ProduccionModel(
        proNombre: "Producción Lote C-789",
        proFechaInicio: DateTime.now().subtract(const Duration(days: 10)),
        proFechaFin: DateTime.now(),
        proCantidad: 1000,
        proEtapa: "Finalizado",
      ),
    ];
  }

  // Selector de fechas
  Future<void> _seleccionarFecha(BuildContext context, bool esFechaInicio) async {
    final DateTime? fechaSeleccionada = await showDatePicker(
      context: context,
      initialDate: esFechaInicio ? _fechaInicio : _fechaFin,
      firstDate: DateTime(2023),
      lastDate: DateTime(2030),
      builder: (context, child) {
        return Theme(
          data: ThemeData.light().copyWith(
            primaryColor: primaryColor,
            colorScheme: ColorScheme.light(primary: primaryColor),
            buttonTheme: const ButtonThemeData(
              textTheme: ButtonTextTheme.primary
            ),
          ),
          child: child!,
        );
      },
    );

    if (fechaSeleccionada != null) {
      setState(() {
        if (esFechaInicio) {
          _fechaInicio = fechaSeleccionada;
          // Asegurar que la fecha fin no sea anterior a la fecha inicio
          if (_fechaFin.isBefore(_fechaInicio)) {
            _fechaFin = _fechaInicio.add(const Duration(days: 1));
          }
        } else {
          _fechaFin = fechaSeleccionada;
        }
      });
    }
  }

  // Selector de imagen compatible con Web y Mobile
  Future<void> _seleccionarImagen() async {
    try {
      final ImagePicker _picker = ImagePicker();
      final XFile? imagen = await _picker.pickImage(source: ImageSource.gallery);
      
      if (imagen != null) {
        if (kIsWeb) {
          // Solución para Web: leer bytes y mostrar desde memoria
          final bytes = await imagen.readAsBytes();
          setState(() {
            _webImage = bytes;
            _imagenSeleccionada = true;
          });
        } else {
          // Solución para Mobile: guardar path
          setState(() {
            _imagenPath = imagen.path;
            _imagenSeleccionada = true;
          });
        }
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error al seleccionar imagen: $e'))
      );
    }
  }

  // Mostrar detalles en un modal
  void _mostrarDetalles(ProduccionModel produccion) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.7,
        minChildSize: 0.5,
        maxChildSize: 0.95,
        expand: false,
        builder: (_, scrollController) => SingleChildScrollView(
          controller: scrollController,
          child: Padding(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Expanded(
                      child: Text(
                        produccion.proNombre,
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                          color: primaryColor,
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                    IconButton(
                      icon: const Icon(Icons.close),
                      onPressed: () => Navigator.pop(context),
                    ),
                  ],
                ),
                const SizedBox(height: 20),
                _detalleItem('Etapa', produccion.proEtapa, Icons.assignment),
                _detalleItem(
                  'Período', 
                  '${DateFormat('dd/MM/yyyy').format(produccion.proFechaInicio)} - ${DateFormat('dd/MM/yyyy').format(produccion.proFechaFin)}',
                  Icons.date_range
                ),
                _detalleItem('Cantidad', '${produccion.proCantidad} unidades', Icons.inventory),
                
                const SizedBox(height: 20),
                Text(
                  'Progreso de Producción',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: primaryColor,
                  ),
                ),
                const SizedBox(height: 10),
                ClipRRect(
                  borderRadius: BorderRadius.circular(10),
                  child: LinearProgressIndicator(
                    value: _calcularPorcentajeProgreso(produccion) / 100,
                    backgroundColor: Colors.grey[200],
                    color: _obtenerColorEtapa(produccion.proEtapa),
                    minHeight: 12,
                  ),
                ),
                const SizedBox(height: 5),
                Align(
                  alignment: Alignment.centerRight,
                  child: Text(
                    '${_calcularPorcentajeProgreso(produccion).toStringAsFixed(0)}%',
                    style: TextStyle(
                      fontSize: 14,
                      color: primaryColor,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
                
                const SizedBox(height: 30),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    ElevatedButton.icon(
                      icon: const Icon(Icons.edit),
                      label: const Text('Editar'),
                      onPressed: () {
                        Navigator.pop(context);
                        // Buscar índice de la producción actual
                        final index = _producciones.indexWhere(
                          (p) => p.proNombre == produccion.proNombre && 
                                  p.proFechaInicio == produccion.proFechaInicio
                        );
                        if (index != -1) {
                          _editarProduccion(index);
                        }
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: secondaryColor,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                      ),
                    ),
                    OutlinedButton.icon(
                      icon: Icon(Icons.delete_outline, color: primaryColor),
                      label: Text('Eliminar', style: TextStyle(color: primaryColor)),
                      onPressed: () {
                        Navigator.pop(context);
                        _confirmarEliminacion(produccion);
                      },
                      style: OutlinedButton.styleFrom(
                        side: BorderSide(color: primaryColor),
                        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  // Widget para mostrar detalles en el modal
  Widget _detalleItem(String titulo, String valor, IconData icono) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15),
      child: Row(
        children: [
          Icon(icono, color: secondaryColor, size: 24),
          const SizedBox(width: 12),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                titulo,
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey[600],
                ),
              ),
              Text(
                valor,
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  // Confirmar eliminación con diálogo
  void _confirmarEliminacion(ProduccionModel produccion) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Confirmar eliminación'),
        content: Text('¿Está seguro de eliminar la producción "${produccion.proNombre}"?'),
        actions: [
          TextButton(
            child: const Text('Cancelar'),
            onPressed: () => Navigator.pop(context),
          ),
          ElevatedButton(
            child: const Text('Eliminar'),
            onPressed: () {
              setState(() {
                _producciones.removeWhere(
                  (p) => p.proNombre == produccion.proNombre && 
                          p.proFechaInicio == produccion.proFechaInicio
                );
              });
              Navigator.pop(context);
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('Producción eliminada con éxito')),
              );
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.red,
            ),
          ),
        ],
      ),
    );
  }

  // Guardar producción (crear o actualizar)
  Future<void> _guardarProduccion() async {
    if (_formKey.currentState!.validate()) {
      setState(() {
        _estaCargando = true;
      });

      try {
        // Crear instancia del modelo con los datos del formulario
        final nuevaProduccion = ProduccionModel(
          proNombre: _nombreController.text,
          proFechaInicio: _fechaInicio,
          proFechaFin: _fechaFin,
          proCantidad: int.parse(_cantidadController.text),
          proEtapa: _etapaSeleccionada,
          proImg: _imagenPath,
        );

        // Preparar datos para enviar a la API
        final produccionData = await nuevaProduccion.jsonForProduction();
        
        if (_modoEdicion) {
          // Actualizar producción existente
          try {
            await nuevaProduccion.productionUpdate(produccionData);
            setState(() {
              _producciones[_indiceEdicion] = nuevaProduccion;
            });
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Producción actualizada con éxito')),
            );
          } catch (e) {
            // En caso de error en la API, actualizar solo localmente
            setState(() {
              _producciones[_indiceEdicion] = nuevaProduccion;
            });
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Producción actualizada localmente')),
            );
          }
        } else {
          // Crear nueva producción
          try {
            await nuevaProduccion.productionCreate(produccionData);
            setState(() {
              _producciones.add(nuevaProduccion);
            });
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Producción creada con éxito')),
            );
          } catch (e) {
            // En caso de error en la API, agregar solo localmente
            setState(() {
              _producciones.add(nuevaProduccion);
            });
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Producción creada localmente')),
            );
          }
        }

        // Limpiar formulario
        _limpiarFormulario();
      } catch (e) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e')),
        );
      } finally {
        setState(() {
          _estaCargando = false;
        });
      }
    }
  }

  // Editar producción existente
  void _editarProduccion(int index) {
    final produccion = _producciones[index];
    setState(() {
      _nombreController.text = produccion.proNombre;
      _fechaInicio = produccion.proFechaInicio;
      _fechaFin = produccion.proFechaFin;
      _cantidadController.text = produccion.proCantidad.toString();
      _etapaSeleccionada = produccion.proEtapa;
      _imagenPath = produccion.proImg;
      _imagenSeleccionada = produccion.proImg != null;
      _modoEdicion = true;
      _indiceEdicion = index;
    });

    // Desplazar hacia el formulario
    Scrollable.ensureVisible(
      _formKey.currentContext!,
      duration: const Duration(milliseconds: 500),
      curve: Curves.easeInOut,
    );
  }

  // Limpiar formulario
  void _limpiarFormulario() {
    setState(() {
      _nombreController.clear();
      _cantidadController.clear();
      _fechaInicio = DateTime.now();
      _fechaFin = DateTime.now().add(const Duration(days: 7));
      _etapaSeleccionada = 'Planificación';
      _imagenPath = null;
      _webImage = null;
      _imagenSeleccionada = false;
      _modoEdicion = false;
      _indiceEdicion = -1;
    });
  }

  // Color según etapa de producción
  Color _obtenerColorEtapa(String etapa) {
    switch (etapa) {
      case 'Planificación':
        return primaryColor.withOpacity(0.8);
      case 'Preparación':
        return secondaryColor.withOpacity(0.8);
      case 'Fabricación':
        return Colors.orange;
      case 'Control de Calidad':
        return Colors.yellow[700]!;
      case 'Empaquetado':
        return secondaryColor;
      case 'Distribución':
        return Colors.purple;
      case 'Finalizado':
        return primaryColor;
      default:
        return Colors.grey;
    }
  }

  // Porcentaje de progreso
  double _calcularPorcentajeProgreso(ProduccionModel produccion) {
    final now = DateTime.now();
    
    // Si ya pasó la fecha final
    if (now.isAfter(produccion.proFechaFin)) {
      return 100.0;
    }
    
    // Si no ha comenzado
    if (now.isBefore(produccion.proFechaInicio)) {
      return 0.0;
    }
    
    // Calcular porcentaje
    final totalDuracion = produccion.proFechaFin.difference(produccion.proFechaInicio).inSeconds;
    final transcurridos = now.difference(produccion.proFechaInicio).inSeconds;
    
    return (transcurridos / totalDuracion) * 100;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Gestión de Producción',
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        backgroundColor: primaryColor,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh, color: Colors.white),
            onPressed: () {
              // Recargar datos
              setState(() {});
            },
          ),
        ],
      ),
      body: _estaCargando 
        ? Center(child: CircularProgressIndicator(color: secondaryColor))
        : SingleChildScrollView(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Formulario de creación/edición
                Card(
                  elevation: 4,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Form(
                      key: _formKey,
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            _modoEdicion ? 'Editar Producción' : 'Nueva Producción',
                            style: TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                              color: primaryColor,
                            ),
                          ),
                          const SizedBox(height: 16),
                          TextFormField(
                            controller: _nombreController,
                            decoration: InputDecoration(
                              labelText: 'Nombre de la producción',
                              labelStyle: TextStyle(color: primaryColor.withOpacity(0.7)),
                              prefixIcon: Icon(Icons.production_quantity_limits, color: primaryColor),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                                borderSide: BorderSide(color: primaryColor, width: 2),
                              ),
                            ),
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor, ingrese un nombre';
                              }
                              return null;
                            },
                          ),
                          const SizedBox(height: 16),
                          Row(
                            children: [
                              Expanded(
                                child: GestureDetector(
                                  onTap: () => _seleccionarFecha(context, true),
                                  child: AbsorbPointer(
                                    child: TextFormField(
                                      decoration: InputDecoration(
                                        labelText: 'Fecha Inicio',
                                        labelStyle: TextStyle(color: primaryColor.withOpacity(0.7)),
                                        prefixIcon: Icon(Icons.calendar_today, color: primaryColor),
                                        border: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(8),
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(8),
                                          borderSide: BorderSide(color: primaryColor, width: 2),
                                        ),
                                      ),
                                      controller: TextEditingController(
                                        text: DateFormat('dd/MM/yyyy').format(_fechaInicio),
                                      ),
                                    ),
                                  ),
                                ),
                              ),
                              const SizedBox(width: 16),
                              Expanded(
                                child: GestureDetector(
                                  onTap: () => _seleccionarFecha(context, false),
                                  child: AbsorbPointer(
                                    child: TextFormField(
                                      decoration: InputDecoration(
                                        labelText: 'Fecha Final',
                                        labelStyle: TextStyle(color: primaryColor.withOpacity(0.7)),
                                        prefixIcon: Icon(Icons.event, color: primaryColor),
                                        border: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(8),
                                        ),
                                        focusedBorder: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(8),
                                          borderSide: BorderSide(color: primaryColor, width: 2),
                                        ),
                                      ),
                                      controller: TextEditingController(
                                        text: DateFormat('dd/MM/yyyy').format(_fechaFin),
                                      ),
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 16),
                          TextFormField(
                            controller: _cantidadController,
                            decoration: InputDecoration(
                              labelText: 'Cantidad',
                              labelStyle: TextStyle(color: primaryColor.withOpacity(0.7)),
                              prefixIcon: Icon(Icons.inventory, color: primaryColor),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                                borderSide: BorderSide(color: primaryColor, width: 2),
                              ),
                            ),
                            keyboardType: TextInputType.number,
                            inputFormatters: [
                              FilteringTextInputFormatter.digitsOnly,
                            ],
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor, ingrese una cantidad';
                              }
                              return null;
                            },
                          ),
                          const SizedBox(height: 16),
                          DropdownButtonFormField<String>(
                            value: _etapaSeleccionada,
                            decoration: InputDecoration(
                              labelText: 'Etapa de Producción',
                              labelStyle: TextStyle(color: primaryColor.withOpacity(0.7)),
                              prefixIcon: Icon(Icons.assignment, color: primaryColor),
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(8),
                                borderSide: BorderSide(color: primaryColor, width: 2),
                              ),
                            ),
                            items: _etapasProduccion.map((String etapa) {
                              return DropdownMenuItem<String>(
                                value: etapa,
                                child: Text(etapa),
                              );
                            }).toList(),
                            onChanged: (value) {
                              setState(() {
                                _etapaSeleccionada = value!;
                              });
                            },
                            dropdownColor: Colors.white,
                            icon: Icon(Icons.arrow_drop_down, color: primaryColor),
                          ),
                          const SizedBox(height: 16),
                          GestureDetector(
                            onTap: _seleccionarImagen,
                            child: Container(
                              height: 120,
                              decoration: BoxDecoration(
                                color: Colors.grey[200],
                                borderRadius: BorderRadius.circular(8),
                                border: Border.all(color: primaryColor.withOpacity(0.5)),
                              ),
                              child: _mostrarImagen(),
                            ),
                          ),
                          const SizedBox(height: 24),
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              OutlinedButton.icon(
                                icon: const Icon(Icons.clear),
                                label: const Text('Cancelar'),
                                onPressed: _limpiarFormulario,
                                style: OutlinedButton.styleFrom(
                                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                                  side: BorderSide(color: primaryColor),
                                  foregroundColor: primaryColor,
                                ),
                              ),
                              ElevatedButton.icon(
                                icon: Icon(_modoEdicion ? Icons.save : Icons.add),
                                label: Text(_modoEdicion ? 'Actualizar' : 'Crear'),
                                onPressed: _guardarProduccion,
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: secondaryColor,
                                  foregroundColor: Colors.white,
                                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
                
                const SizedBox(height: 24),
                
                // Estadísticas generales
                Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: [primaryColor, primaryColor.withOpacity(0.8)],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Resumen de Producción',
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 16),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceAround,
                        children: [
                          _estadisticaItem(
                            'Total', 
                            _producciones.length.toString(),
                            Icons.assignment
                          ),
                          _estadisticaItem(
                            'En proceso', 
                            _producciones.where((p) => p.proEtapa != 'Finalizado').length.toString(),
                            Icons.sync
                          ),
                          _estadisticaItem(
                            'Finalizadas', 
                            _producciones.where((p) => p.proEtapa == 'Finalizado').length.toString(),
                            Icons.check_circle
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              
                const SizedBox(height: 24),
                
                // Lista de producciones
                Text(
                  'Producciones Activas',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: primaryColor,
                  ),
                ),
                const SizedBox(height: 8),
                
                if (_producciones.isEmpty)
                  const Center(
                    child: Padding(
                      padding: EdgeInsets.all(32.0),
                      child: Text(
                        'No hay producciones registradas',
                        style: TextStyle(
                          fontSize: 16,
                          color: Colors.grey,
                        ),
                      ),
                    ),
                  )
                else
                  ListView.builder(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: _producciones.length,
                    itemBuilder: (context, index) {
                      final produccion = _producciones[index];
                      final progreso = _calcularPorcentajeProgreso(produccion);
                      
                      return Card(
                        elevation: 2,
                        margin: const EdgeInsets.only(bottom: 12),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: InkWell(
                          onTap: () => _mostrarDetalles(produccion),
                          borderRadius: BorderRadius.circular(12),
                          child: Padding(
                            padding: const EdgeInsets.all(12.0),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Expanded(
                                      child: Text(
                                        produccion.proNombre,
                                        style: const TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                        ),
                                        maxLines: 1,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ),
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                      decoration: BoxDecoration(
                                        color: _obtenerColorEtapa(produccion.proEtapa),
                                        borderRadius: BorderRadius.circular(12),
                                      ),
                                      child: Text(
                                        produccion.proEtapa,
                                        style: const TextStyle(
                                          color: Colors.white,
                                          fontSize: 12,
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 8),
                                Row(
                                  children: [
                                    Icon(Icons.calendar_today, size: 16, color: Colors.grey),
                                    const SizedBox(width: 4),
                                    Text(
                                      '${DateFormat('dd/MM/yyyy').format(produccion.proFechaInicio)} - ${DateFormat('dd/MM/yyyy').format(produccion.proFechaFin)}',
                                      style: const TextStyle(color: Colors.grey),
                                    ),
                                    const SizedBox(width: 16),
                                    Icon(Icons.inventory_2, size: 16, color: Colors.grey),
                                    const SizedBox(width: 4),
                                    Text(
                                      '${produccion.proCantidad} unidades',
                                      style: const TextStyle(color: Colors.grey),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 12),
                                ClipRRect(
                                  borderRadius: BorderRadius.circular(8),
                                  child: LinearProgressIndicator(
                                    value: progreso / 100,
                                    backgroundColor: Colors.grey[200],
                                    color: _obtenerColorEtapa(produccion.proEtapa),
                                    minHeight: 8,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Align(
                                  alignment: Alignment.centerRight,
                                  child: Text(
                                    '${progreso.toStringAsFixed(0)}%',
                                    style: TextStyle(
                                      fontSize: 12,
                                      color: Colors.grey[700],
                                    ),
                                  ),
                                ),
                                const SizedBox(height: 8),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.end,
                                  children: [
                                    IconButton(
                                      icon: Icon(Icons.edit, color: secondaryColor),
                                      onPressed: () => _editarProduccion(index),
                                      tooltip: 'Editar',
                                    ),
                                    IconButton(
                                      icon: Icon(Icons.visibility, color: primaryColor),
                                      onPressed: () => _mostrarDetalles(produccion),
                                      tooltip: 'Ver detalles',
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ),
                      );
                    },
                  ),
              ],
            ),
          ),
    );
  }

  // Widget para mostrar la imagen seleccionada
  Widget _mostrarImagen() {
    if (kIsWeb) {
      // Para web, mostrar desde bytes
      if (_webImage != null && _imagenSeleccionada) {
        return ClipRRect(
          borderRadius: BorderRadius.circular(8),
          child: Image.memory(
            _webImage!,
            fit: BoxFit.cover,
            width: double.infinity,
          ),
        );
      }
    } else {
      // Para móvil, mostrar desde path
      if (_imagenPath != null && _imagenSeleccionada) {
        return ClipRRect(
          borderRadius: BorderRadius.circular(8),
          child: Image.file(
            File(_imagenPath!),
            fit: BoxFit.cover,
            width: double.infinity,
          ),
        );
      }
    }
    
    // Si no hay imagen seleccionada
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.add_a_photo, size: 40, color: primaryColor.withOpacity(0.7)),
          const SizedBox(height: 8),
          Text('Agregar Imagen', style: TextStyle(color: primaryColor.withOpacity(0.7))),
        ],
      ),
    );
  }

  Widget _estadisticaItem(String titulo, String valor, IconData icono) {
    return Column(
      children: [
        Icon(icono, color: Colors.white70, size: 28),
        const SizedBox(height: 8),
        Text(
          valor,
          style: const TextStyle(
            color: Colors.white,
            fontSize: 20,
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(height: 4),
        Text(
          titulo,
          style: const TextStyle(
            color: Colors.white70,
            fontSize: 12,
          ),
        ),
      ],
    );
  }

  @override
  void dispose() {
    _nombreController.dispose();
    _cantidadController.dispose();
    super.dispose();
  }
}
=======
import 'package:buzosmt/Domains/models/produccion_model.dart';

//
>>>>>>> origin/AppMobile
