import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});
  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  Map<String,dynamic>? _data;
  bool _loading = true;
  String? _error;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    try {
      final d = await ApiService.getHome();
      if (mounted) setState(() { _data = d['data']; _loading = false; });
    } catch(e) {
      if (mounted) setState(() { _error = 'خطا در بارگذاری'; _loading = false; });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bg,
      body: RefreshIndicator(
        onRefresh: _load,
        child: CustomScrollView(slivers: [
          // ── App Bar ──────────────────────────────────────
          SliverAppBar(
            expandedHeight: 180,
            pinned: true,
            backgroundColor: AppColors.primary,
            flexibleSpace: FlexibleSpaceBar(
              background: Container(
                decoration: BoxDecoration(gradient: LinearGradient(
                  colors: [AppColors.primaryDark, AppColors.primaryLight],
                  begin: Alignment.topRight, end: Alignment.bottomLeft)),
                child: Center(child: Column(mainAxisAlignment:MainAxisAlignment.center, children:[
                  const SizedBox(height:40),
                  const Icon(Icons.factory_rounded, size:48, color:Colors.white),
                  const SizedBox(height:10),
                  const Text('هنرستان هزاره صنعت',
                      style:TextStyle(fontSize:18,fontWeight:FontWeight.bold,color:Colors.white)),
                  const SizedBox(height:4),
                  Text('اولین هنرستان جوار صنعت غرب کشور',
                      style:TextStyle(fontSize:12,color:Colors.white.withOpacity(0.75))),
                ])),
              ),
            ),
          ),

          if (_loading) const SliverFillRemaining(child: LoadingState()),
          if (_error != null) SliverFillRemaining(child:
            EmptyState(icon: Icons.wifi_off, message: _error!)),

          if (_data != null) ...[
            // ── آمار ─────────────────────────────────────
            SliverToBoxAdapter(child: Container(
              color: AppColors.primary,
              padding: const EdgeInsets.symmetric(vertical:14),
              child: Row(mainAxisAlignment:MainAxisAlignment.spaceEvenly,
                children:[
                  _stat('۶۹', 'هنرجو'),
                  _statDivider(),
                  _stat('۳', 'رشته تخصصی'),
                  _statDivider(),
                  _stat('۳', 'همکار صنعتی'),
                  _statDivider(),
                  _stat('۱۴۰۴', 'سال تأسیس'),
                ]),
            )),

            // ── اخبار اخیر ───────────────────────────────
            SliverToBoxAdapter(child: Padding(
              padding: const EdgeInsets.fromLTRB(16,20,16,4),
              child: Row(mainAxisAlignment:MainAxisAlignment.spaceBetween, children:[
                const SectionHeader(eyebrow:'آخرین اخبار', title:'اخبار هنرستان'),
                TextButton(onPressed:()=>Navigator.pushNamed(context,'/news'),
                  child:const Text('همه اخبار')),
              ]),
            )),

            SliverList(delegate: SliverChildBuilderDelegate((ctx, i) {
              final items = _data!['latest_news'] as List? ?? [];
              if (i >= items.length) return null;
              final n = items[i];
              return NewsCard(
                title: n['title'] ?? '',
                category: _catLabel(n['category']),
                date: n['published_at'] != null
                    ? (n['published_at'] as String).substring(0,10) : null,
                imageUrl: n['image'] != null
                    ? '${ApiService.storageUrl}news/${n["image"]}' : null,
                onTap: () => Navigator.pushNamed(context, '/news',
                    arguments: n['slug']),
              );
            }, childCount: (_data!['latest_news'] as List? ?? []).length)),

            // ── دسترسی سریع ──────────────────────────────
            SliverToBoxAdapter(child: Padding(
              padding: const EdgeInsets.fromLTRB(16,24,16,8),
              child: const SectionHeader(eyebrow:'سامانه‌ها', title:'دسترسی سریع'),
            )),

            SliverPadding(
              padding: const EdgeInsets.fromLTRB(16,0,16,24),
              sliver: SliverGrid(
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisCount:2, mainAxisSpacing:12, crossAxisSpacing:12, childAspectRatio:1.6),
                delegate: SliverChildListDelegate([
                  _quickCard(Icons.person_add_outlined, 'پیش‌ثبت‌نام',
                      AppColors.primary, ()=>Navigator.pushNamed(context,'/reg-check')),
                  _quickCard(Icons.chat_bubble_outline, 'مشاوره آنلاین',
                      const Color(0xFF059669), ()=>Navigator.pushNamed(context,'/counseling')),
                  _quickCard(Icons.emoji_events_outlined, 'همایش بین‌المللی',
                      AppColors.accent, ()=>Navigator.pushNamed(context,'/conference')),
                  _quickCard(Icons.campaign_outlined, 'تابلو اعلانات',
                      const Color(0xFF7C3AED), ()=>Navigator.pushNamed(context,'/announcements')),
                ]),
              ),
            ),
          ],
        ]),
      ),
    );
  }

  Widget _stat(String n, String l) => Column(children:[
    Text(n, style:const TextStyle(fontSize:18,fontWeight:FontWeight.bold,color:Color(0xFFF59E0B))),
    const SizedBox(height:2),
    Text(l, style:TextStyle(fontSize:10,color:Colors.white.withOpacity(0.75))),
  ]);

  Widget _statDivider() => Container(width:1,height:30,color:Colors.white.withOpacity(0.2));

  Widget _quickCard(IconData icon, String label, Color color, VoidCallback onTap) =>
    InkWell(onTap:onTap, borderRadius:BorderRadius.circular(14), child:
      Container(decoration:BoxDecoration(color:color,borderRadius:BorderRadius.circular(14)),
        child:Center(child:Column(mainAxisSize:MainAxisSize.min,children:[
          Icon(icon,color:Colors.white,size:28),
          const SizedBox(height:6),
          Text(label,style:const TextStyle(color:Colors.white,fontSize:12,fontWeight:FontWeight.bold)),
        ]))));

  String _catLabel(String? c) {
    const m = {'electrical':'برق صنعتی','mechanical':'تاسیسات مکانیکی',
      'instrumentation':'ابزار دقیق','extra':'فوق‌برنامه'};
    return m[c] ?? 'عمومی';
  }
}
