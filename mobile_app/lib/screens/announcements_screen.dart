import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class AnnouncementsScreen extends StatefulWidget {
  const AnnouncementsScreen({super.key});
  @override
  State<AnnouncementsScreen> createState() => _AnnouncementsScreenState();
}

class _AnnouncementsScreenState extends State<AnnouncementsScreen>
    with SingleTickerProviderStateMixin {
  Map? _data;
  bool _loading = true;
  late TabController _tabs;

  final _sections = [
    {'key':'educational','label':'آموزشی','icon':Icons.book_outlined},
    {'key':'counseling','label':'مشاوره‌ای','icon':Icons.chat_outlined},
    {'key':'nurturing','label':'پرورشی','icon':Icons.star_outline},
  ];

  @override
  void initState() {
    super.initState();
    _tabs = TabController(length: 3, vsync: this);
    _load();
  }

  Future<void> _load() async {
    try {
      final d = await ApiService.getAnnouncements();
      if (mounted) setState(() { _data = d['data'] ?? {}; _loading = false; });
    } catch(_) {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  void dispose() { _tabs.dispose(); super.dispose(); }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(
      title: const Text('تابلو اعلانات'),
      bottom: TabBar(
        controller: _tabs,
        indicatorColor: AppColors.accent,
        labelColor: Colors.white,
        unselectedLabelColor: Colors.white60,
        tabs: _sections.map((s) => Tab(
          text: s['label'] as String,
          icon: Icon(s['icon'] as IconData, size:16),
        )).toList(),
      ),
    ),
    body: _loading ? const LoadingState() :
    TabBarView(controller: _tabs, children: _sections.map((s) {
      final items = _data?[s['key']] as List? ?? [];
      if (items.isEmpty) return const EmptyState(
          icon: Icons.campaign_outlined, message: 'اعلانی موجود نیست');
      return RefreshIndicator(
        onRefresh: _load,
        child: ListView.separated(
          padding: const EdgeInsets.all(16),
          itemCount: items.length,
          separatorBuilder: (_,__) => const Divider(height:1),
          itemBuilder: (ctx, i) {
            final a = items[i];
            return ListTile(
              contentPadding: const EdgeInsets.symmetric(vertical:8),
              leading: Container(width:4, height:50,
                decoration:BoxDecoration(
                  color:AppColors.accent, borderRadius:BorderRadius.circular(2))),
              title: Text(a['title']??'', style:const TextStyle(fontWeight:FontWeight.w600)),
              subtitle: Text(a['created_at']?.toString().substring(0,10)??'',
                  style:const TextStyle(fontSize:12)),
              onTap: () => _showDetail(context, a),
            );
          },
        ),
      );
    }).toList()),
  );

  void _showDetail(BuildContext context, Map a) {
    showModalBottomSheet(context:context, isScrollControlled:true,
      shape:const RoundedRectangleBorder(
          borderRadius:BorderRadius.vertical(top:Radius.circular(20))),
      builder:(_) => DraggableScrollableSheet(
        initialChildSize:0.5, maxChildSize:0.9, minChildSize:0.3,
        expand:false,
        builder:(__,scroll) => SingleChildScrollView(
          controller:scroll,
          padding:const EdgeInsets.all(20),
          child:Column(crossAxisAlignment:CrossAxisAlignment.start, children:[
            Center(child:Container(width:40,height:4,
                decoration:BoxDecoration(color:Colors.grey.shade300,
                    borderRadius:BorderRadius.circular(2)))),
            const SizedBox(height:16),
            Text(a['title']??'',
                style:const TextStyle(fontSize:17,fontWeight:FontWeight.bold)),
            const SizedBox(height:8),
            Text(a['created_at']?.toString().substring(0,10)??'',
                style:TextStyle(fontSize:12,color:Colors.grey.shade500)),
            const Divider(height:24),
            Text(a['body']??'', style:const TextStyle(fontSize:14,height:1.8)),
          ]),
        ),
      ),
    );
  }
}
