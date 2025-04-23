import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:fl_chart/fl_chart.dart';
import 'package:buzosmt/Presentation/screens/tareas_screen.dart';
import 'configuration_user.dart';
import 'etapas_screen.dart';
import '../../main.dart';
import 'package:buzosmt/Presentation/screens/gestion_produccion_screen.dart';

class Dashboard extends StatefulWidget {
  const Dashboard({Key? key, required this.userData}) : super(key: key);
  final Map<String, dynamic> userData;

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  int selectedIndex = 0;
  String selectedPeriod = 'Semanal';

  // Datos de ejemplo para gráficas
  final List<ProductionData> weeklyData = [
    ProductionData('Lun', 70),
    ProductionData('Mar', 58),
    ProductionData('Mié', 63),
    ProductionData('Jue', 76),
    ProductionData('Vie', 82),
    ProductionData('Sáb', 35),
    ProductionData('Dom', 20),
  ];

  final List<ProductionItem> recentItems = [
    ProductionItem('Buzo Rojo', 235, 'Completado', Colors.green),
    ProductionItem('Buzo Azul', 128, 'En proceso', Colors.orange),
    ProductionItem('Buzo Verde', 94, 'Retrasado', Colors.red),
    ProductionItem('Buzo Morado', 182, 'Completado', Colors.green),
  ];

  Future<void> _logout(BuildContext context) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('token');

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => const MyHomePage()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: const Color(0xFF0D3D4A),
        elevation: 0,
        title: Row(
          children: [
            const Text(
              'Dashboard Producción',
              style: TextStyle(
                fontWeight: FontWeight.bold,
                color: Colors.white,
              ),
            ),
            const Spacer(),
            IconButton(
              icon: const Icon(
                Icons.notifications_outlined,
                color: Colors.white,
              ),
              onPressed: () {},
            ),
          ],
        ),
      ),
      drawer: _buildDrawer(context),
      body: _buildBody(),
      bottomNavigationBar: _buildBottomNavigationBar(),
    );
  }

  Widget _buildDrawer(BuildContext context) {
    final userData = widget.userData; // Accede a los datos del usuario

    return Drawer(
      child: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [Color(0xFF0D3D4A), Color(0xFF20A67B)],
          ),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.symmetric(vertical: 30),
              child: Center(
                child: Column(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(4),
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.2),
                        shape: BoxShape.circle,
                      ),
                      child: CircleAvatar(
                        radius: 35,
                        backgroundColor: Colors.white,
                        backgroundImage:
                            userData['imag_perfil'] != null
                                ? NetworkImage(
                                  'http://tu-servidor.com/${userData['imag_perfil']}',
                                )
                                : const AssetImage('assets/images/logo.png')
                                    as ImageProvider,
                      ),
                    ),
                    const SizedBox(height: 12),
                    Text(
                      '${userData['usu_nombres']} ${userData['usu_apellidos']}',
                      style: const TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.bold,
                        fontSize: 18,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 4,
                      ),
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.2),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: Text(
                        userData['email'] ?? 'Sin correo',
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 12,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
            const Divider(color: Colors.white30, height: 1),
            Expanded(
              child: ListView(
                padding: EdgeInsets.zero,
                children: [
                  _buildDrawerItem(
                    Icons.dashboard,
                    'Dashboard',
                    onTap: () => Navigator.pop(context),
                    isSelected: true,
                  ),
                  ExpansionTile(
                    iconColor: Colors.white,
                    collapsedIconColor: Colors.white,
                    leading: const Icon(Icons.factory, color: Colors.white),
                    title: const Text(
                      'Producción',
                      style: TextStyle(color: Colors.white),
                    ),
                    children: [
                      _buildDrawerSubItem(
                        Icons.assessment,
                        'Gestión de Producción',
                        onTap: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder:
                                  (context) => const GestionProduccionScreen(),
                            ),
                          );
                        },
                      ),
                    ],
                  ),
                  _buildDrawerItem(
                    Icons.calendar_today,
                    'Tareas',
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => const TareasScreen(),
                        ),
                      );
                    },
                  ),
                  _buildDrawerItem(
                    Icons.layers,
                    'Etapas',
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => const EtapasScreen(),
                        ),
                      );
                    },
                  ),
                  _buildDrawerItem(
                    Icons.settings,
                    'Configuración',
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => ConfigurationUserScreen(userData: widget.userData),
                        ),
                      );
                    },
                  ),
                ],
              ),
            ),
            const Divider(color: Colors.white30, height: 1),
            ListTile(
              leading: const Icon(Icons.logout, color: Colors.white),
              title: const Text(
                'Cerrar Sesión',
                style: TextStyle(color: Colors.white),
              ),
              onTap: () => _logout(context),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDrawerItem(
    IconData icon,
    String text, {
    VoidCallback? onTap,
    bool isSelected = false,
  }) {
    return ListTile(
      leading: Icon(icon, color: Colors.white),
      title: Text(
        text,
        style: TextStyle(
          color: Colors.white,
          fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
        ),
      ),
      onTap: onTap ?? () {},
      selectedTileColor: Colors.white.withOpacity(0.1),
      selected: isSelected,
    );
  }

  Widget _buildDrawerSubItem(
    IconData icon,
    String text, {
    VoidCallback? onTap,
  }) {
    return ListTile(
      contentPadding: const EdgeInsets.only(left: 70),
      leading: Icon(icon, color: Colors.white70, size: 20),
      title: Text(
        text,
        style: const TextStyle(color: Colors.white70, fontSize: 14),
      ),
      onTap: onTap ?? () {},
    );
  }

  Widget _buildBody() {
    return Container(
      color: Colors.grey.shade100,
      child: LayoutBuilder(
        builder: (context, constraints) {
          // Si el ancho es mayor a 900px, usamos diseño de tablet/desktop
          if (constraints.maxWidth >= 900) {
            return _buildWideLayout();
          } else {
            // Para dispositivos móviles usamos diseño en columna
            return _buildNarrowLayout();
          }
        },
      ),
    );
  }

  Widget _buildWideLayout() {
    // Diseño adaptado para pantallas grandes (tablet/desktop)
    return SingleChildScrollView(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildHeader(),
          const SizedBox(height: 24),
          // Primera fila: gráfica y estadísticas
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Gráfica ocupa el 65% del ancho
              Expanded(flex: 65, child: _buildChartSection()),
              const SizedBox(width: 24),
              // Estadísticas ocupan el 35% del ancho
              Expanded(
                flex: 35,
                child: Column(
                  children: [
                    _buildStatCard(
                      'Total Producción',
                      '586',
                      'unidades',
                      Icons.inventory_2,
                      const Color(0xFF0D3D4A),
                      '+12% vs semana anterior',
                    ),
                    const SizedBox(height: 16),
                    _buildStatCard(
                      'Eficiencia',
                      '94',
                      '%',
                      Icons.speed,
                      const Color(0xFF20A67B),
                      '+3% vs semana anterior',
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 24),
          // Producción reciente
          _buildRecentProduction(),
        ],
      ),
    );
  }

  Widget _buildNarrowLayout() {
    // Diseño para dispositivos móviles
    return SingleChildScrollView(
      padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildHeader(),
          const SizedBox(height: 20),
          _buildChartSection(),
          const SizedBox(height: 20),
          // En móvil, las estadísticas se muestran en fila o columna según el ancho
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth >= 600) {
                // Para tabletas en vertical o móviles landscape
                return Row(
                  children: [
                    Expanded(
                      child: _buildStatCard(
                        'Total Producción',
                        '586',
                        'unidades',
                        Icons.inventory_2,
                        const Color(0xFF0D3D4A),
                        '+12% vs semana anterior',
                      ),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: _buildStatCard(
                        'Eficiencia',
                        '94',
                        '%',
                        Icons.speed,
                        const Color(0xFF20A67B),
                        '+3% vs semana anterior',
                      ),
                    ),
                  ],
                );
              } else {
                // Para móviles en portrait
                return Column(
                  children: [
                    _buildStatCard(
                      'Total Producción',
                      '586',
                      'unidades',
                      Icons.inventory_2,
                      const Color(0xFF0D3D4A),
                      '+12% vs semana anterior',
                    ),
                    const SizedBox(height: 16),
                    _buildStatCard(
                      'Eficiencia',
                      '94',
                      '%',
                      Icons.speed,
                      const Color(0xFF20A67B),
                      '+3% vs semana anterior',
                    ),
                  ],
                );
              }
            },
          ),
          const SizedBox(height: 20),
          _buildRecentProduction(),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    return LayoutBuilder(
      builder: (context, constraints) {
        // Adaptar el header según el ancho disponible
        if (constraints.maxWidth >= 500) {
          // Header en fila para pantallas más anchas
          return Row(
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Panel de Control',
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF0D3D4A),
                    ),
                  ),
                  Text(
                    'Resumen de producción - ${DateTime.now().day}/${DateTime.now().month}/${DateTime.now().year}',
                    style: TextStyle(fontSize: 14, color: Colors.grey.shade600),
                  ),
                ],
              ),
              const Spacer(),
              _buildPeriodDropdown(),
            ],
          );
        } else {
          // Header en columna para pantallas estrechas
          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Panel de Control',
                style: TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF0D3D4A),
                ),
              ),
              Text(
                'Resumen de producción - ${DateTime.now().day}/${DateTime.now().month}/${DateTime.now().year}',
                style: TextStyle(fontSize: 14, color: Colors.grey.shade600),
              ),
              const SizedBox(height: 12),
              Row(children: [const Spacer(), _buildPeriodDropdown()]),
            ],
          );
        }
      },
    );
  }

  Widget _buildPeriodDropdown() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 2,
          ),
        ],
      ),
      child: DropdownButton<String>(
        value: selectedPeriod,
        icon: const Icon(Icons.keyboard_arrow_down, color: Color(0xFF0D3D4A)),
        elevation: 0,
        underline: const SizedBox(),
        style: const TextStyle(color: Color(0xFF0D3D4A)),
        onChanged: (String? newValue) {
          setState(() {
            selectedPeriod = newValue!;
          });
        },
        items:
            <String>[
              'Diario',
              'Semanal',
              'Mensual',
              'Anual',
            ].map<DropdownMenuItem<String>>((String value) {
              return DropdownMenuItem<String>(value: value, child: Text(value));
            }).toList(),
      ),
    );
  }

  Widget _buildChartSection() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Producción Semanal',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Color(0xFF0D3D4A),
            ),
          ),
          const SizedBox(height: 5),
          Text(
            '14 - 20 Abril, 2025',
            style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
          ),
          const SizedBox(height: 20),
          // Altura adaptable para el gráfico
          AspectRatio(
            aspectRatio: 16 / 9, // Proporciones estándar para gráficos
            child: BarChart(
              BarChartData(
                alignment: BarChartAlignment.spaceAround,
                maxY: 100,
                barTouchData: BarTouchData(
                  enabled: true,
                  touchTooltipData: BarTouchTooltipData(
                    tooltipBgColor: const Color(0xFF0D3D4A).withOpacity(0.8),
                    getTooltipItem: (group, groupIndex, rod, rodIndex) {
                      return BarTooltipItem(
                        '${weeklyData[groupIndex].day}: ${rod.toY.round()}',
                        const TextStyle(color: Colors.white),
                      );
                    },
                  ),
                ),
                titlesData: FlTitlesData(
                  show: true,
                  bottomTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true,
                      getTitlesWidget: (value, meta) {
                        // Comprobamos si debemos mostrar etiquetas más cortas
                        return SideTitleWidget(
                          axisSide: meta.axisSide,
                          child: LayoutBuilder(
                            builder: (context, constraints) {
                              // En dispositivos pequeños, usamos iniciales
                              final String label =
                                  MediaQuery.of(context).size.width < 400
                                      ? weeklyData[value.toInt()]
                                          .day[0] // Solo la inicial
                                      : weeklyData[value.toInt()]
                                          .day; // Nombre completo

                              return Text(
                                label,
                                style: TextStyle(
                                  fontSize: 12,
                                  color: Colors.grey.shade700,
                                ),
                              );
                            },
                          ),
                        );
                      },
                      reservedSize: 30,
                    ),
                  ),
                  leftTitles: AxisTitles(
                    sideTitles: SideTitles(
                      showTitles: true,
                      getTitlesWidget: (value, meta) {
                        return SideTitleWidget(
                          axisSide: meta.axisSide,
                          child: Text(
                            value.toInt().toString(),
                            style: TextStyle(
                              fontSize: 12,
                              color: Colors.grey.shade700,
                            ),
                          ),
                        );
                      },
                      reservedSize: 30,
                    ),
                  ),
                  topTitles: const AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                  rightTitles: const AxisTitles(
                    sideTitles: SideTitles(showTitles: false),
                  ),
                ),
                borderData: FlBorderData(show: false),
                gridData: FlGridData(
                  show: true,
                  horizontalInterval: 20,
                  getDrawingHorizontalLine: (value) {
                    return FlLine(color: Colors.grey.shade200, strokeWidth: 1);
                  },
                ),
                barGroups:
                    weeklyData.asMap().entries.map((entry) {
                      final index = entry.key;
                      final data = entry.value;
                      // Ancho adaptativo para barras
                      final double barWidth =
                          MediaQuery.of(context).size.width < 400 ? 10 : 20;
                      return BarChartGroupData(
                        x: index,
                        barRods: [
                          BarChartRodData(
                            toY: data.value,
                            color: const Color(0xFF20A67B),
                            width: barWidth,
                            borderRadius: const BorderRadius.only(
                              topLeft: Radius.circular(4),
                              topRight: Radius.circular(4),
                            ),
                          ),
                        ],
                      );
                    }).toList(),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard(
    String title,
    String value,
    String unit,
    IconData icon,
    Color color,
    String comparison,
  ) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: color.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(icon, color: color, size: 24),
              ),
              const Spacer(),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.green.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: LayoutBuilder(
                  builder: (context, constraints) {
                    // Texto simplificado en pantallas muy pequeñas
                    final String compText =
                        MediaQuery.of(context).size.width < 350
                            ? '+12%' // Versión corta
                            : comparison; // Versión completa

                    return Row(
                      children: [
                        const Icon(
                          Icons.arrow_upward,
                          color: Color(0xFF20A67B),
                          size: 12,
                        ),
                        const SizedBox(width: 2),
                        Text(
                          compText,
                          style: const TextStyle(
                            color: Color(0xFF20A67B),
                            fontSize: 10,
                          ),
                        ),
                      ],
                    );
                  },
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),
          Text(
            title,
            style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
          ),
          const SizedBox(height: 5),
          Row(
            crossAxisAlignment: CrossAxisAlignment.baseline,
            textBaseline: TextBaseline.alphabetic,
            children: [
              Text(
                value,
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Colors.grey.shade900,
                ),
              ),
              const SizedBox(width: 5),
              Text(
                unit,
                style: TextStyle(fontSize: 14, color: Colors.grey.shade600),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildRecentProduction() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'Producción Reciente',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF0D3D4A),
                ),
              ),
              TextButton(
                onPressed: () {},
                child: const Text(
                  'Ver todos',
                  style: TextStyle(color: Color(0xFF20A67B)),
                ),
              ),
            ],
          ),
          const SizedBox(height: 10),
          // Lista adaptativa para producción reciente
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth >= 900) {
                // Para pantallas anchas, mostrar elementos en grid
                return GridView.builder(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisCount: 2,
                    childAspectRatio: 3,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 16,
                  ),
                  itemCount: recentItems.length,
                  itemBuilder: (context, index) {
                    return _buildProductionItem(recentItems[index]);
                  },
                );
              } else {
                // Para pantallas estrechas, mostrar en columna
                return Column(
                  children:
                      recentItems
                          .map((item) => _buildProductionItem(item))
                          .toList(),
                );
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildProductionItem(ProductionItem item) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: const Color(0xFF0D3D4A).withOpacity(0.1),
              borderRadius: BorderRadius.circular(8),
            ),
            child: const Icon(
              Icons.checkroom,
              color: Color(0xFF0D3D4A),
              size: 20,
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  item.name,
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    color: Colors.grey.shade800,
                  ),
                ),
                Text(
                  '${item.quantity} unidades',
                  style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                ),
              ],
            ),
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(
              color: item.color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Text(
              item.status,
              style: TextStyle(fontSize: 12, color: item.color),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBottomNavigationBar() {
    // Solo mostramos el BottomNavigationBar en pantallas pequeñas
    return MediaQuery.of(context).size.width <= 600
        ? BottomNavigationBar(
          currentIndex: selectedIndex,
          onTap: (index) {
            setState(() {
              selectedIndex = index;
            });
          },
          selectedItemColor: const Color(0xFF34E69F),
          unselectedItemColor: Colors.grey,
          backgroundColor: Colors.white,
          type: BottomNavigationBarType.fixed,
          elevation: 10,
          items: const [
            BottomNavigationBarItem(
              icon: Icon(Icons.dashboard),
              label: 'Dashboard',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.factory),
              label: 'Producción',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.analytics),
              label: 'Reportes',
            ),
            BottomNavigationBarItem(icon: Icon(Icons.person), label: 'Perfil'),
          ],
        )
        : const SizedBox.shrink(); // No mostrar en pantallas grandes
  }
}

// Clases para almacenar datos de ejemplo
class ProductionData {
  final String day;
  final double value;

  ProductionData(this.day, this.value);
}

class ProductionItem {
  final String name;
  final int quantity;
  final String status;
  final Color color;

  ProductionItem(this.name, this.quantity, this.status, this.color);
}
