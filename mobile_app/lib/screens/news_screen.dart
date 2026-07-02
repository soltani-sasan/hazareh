import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class NewsScreen extends StatefulWidget {
  const NewsScreen({super.key});
  @override
  State<NewsScreen> createState() => _NewsScreenState();
}

class _NewsScreenState extends State<NewsScreen> {
  List _items = [];
  bool _loading = true;
  String _cat = '';

  final Map<String,String> _cats = {
    '': 'همه', 'general': 'عمومی', 'electrical': 'برق صنعتی',
    'mechanical': 'تاسیسات', 'instrumentation': 'ابزار دقیق',
  };

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try {
      final d = await ApiService.getNews(category: _cat.isEmpty ? null : _cat);
      if (mounted) setState(() {
        _items = d['data']?['data'] ?? [];
        _loading = false;
      });
    } catch(_) {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(title: const Text('اخبار و اطلاعیه‌ها')),
    body: Column(children:[
      // Filter chips
      SizedBox(height:52, child: ListView(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal:12, vertical:8),
        children: _cats.entries.map((e) => Padding(
          padding: const EdgeInsets.only(left:8),
          child: ChoiceChip(
            label: Text(e.value),
            selected: _cat == e.key,
            onSelected: (_) { _cat = e.key; _load(); },
            selectedColor: AppColors.accent,
            labelStyle: TextStyle(
              color: _cat == e.key ? Colors.white : null,
              fontWeight: FontWeight.w600, fontSize:13,
            ),
          ),
        )).toList(),
      )),

      Expanded(child: _loading ? const LoadingState() :
        _items.isEmpty ? const EmptyState(icon:Icons.article_outlined, message:'خبری یافت نشد') :
        RefreshIndicator(
          onRefresh: _load,
          child: ListView.builder(
            itemCount: _items.length,
            itemBuilder: (ctx, i) {
              final n = _items[i];
              return NewsCard(
                title: n['title'] ?? '',
                category: _catLabel(n['category']),
                date: n['published_at'] != null
                    ? (n['published_at'] as String).substring(0,10) : null,
                imageUrl: n['image'] != null
                    ? '${ApiService.storageUrl}news/${n["image"]}' : null,
                onTap: () => Navigator.push(context, MaterialPageRoute(
                  builder: (_) => NewsDetailScreen(slug: n['slug']))),
              );
            },
          ),
        )
      ),
    ]),
  );

  String _catLabel(String? c) {
    const m = {'electrical':'برق صنعتی','mechanical':'تاسیسات مکانیکی',
      'instrumentation':'ابزار دقیق','extra':'فوق‌برنامه'};
    return m[c] ?? 'عمومی';
  }
}

class NewsDetailScreen extends StatefulWidget {
  final String slug;
  const NewsDetailScreen({super.key, required this.slug});
  @override
  State<NewsDetailScreen> createState() => _NewsDetailScreenState();
}

class _NewsDetailScreenState extends State<NewsDetailScreen> {
  Map? _news;
  bool _loading = true;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    try {
      final d = await ApiService.getNewsDetail(widget.slug);
      if (mounted) setState(() { _news = d['data']; _loading = false; });
    } catch(_) {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(title: Text(_news?['title'] ?? 'جزئیات خبر',
        overflow:TextOverflow.ellipsis)),
    body: _loading ? const LoadingState() :
    _news == null ? const EmptyState(icon:Icons.error_outline, message:'خطا در بارگذاری') :
    SingleChildScrollView(child: Column(crossAxisAlignment:CrossAxisAlignment.start, children:[
      if (_news!['image'] != null)
        Image.network('${ApiService.storageUrl}news/${_news!["image"]}',
            height:220, width:double.infinity, fit:BoxFit.cover,
            errorBuilder:(c,e,s)=>const SizedBox()),
      Padding(
        padding: const EdgeInsets.all(16),
        child: Column(crossAxisAlignment:CrossAxisAlignment.start, children:[
          Container(padding:const EdgeInsets.symmetric(horizontal:10,vertical:4),
            decoration:BoxDecoration(color:AppColors.accent.withOpacity(0.1),
                borderRadius:BorderRadius.circular(6)),
            child:Text(_news!['type']=='notice'?'اطلاعیه':'خبر',
                style:TextStyle(fontSize:12,color:AppColors.accent,fontWeight:FontWeight.bold))),
          const SizedBox(height:12),
          Text(_news!['title']??'', style:const TextStyle(fontSize:20,fontWeight:FontWeight.bold)),
          const SizedBox(height:8),
          if (_news!['published_at']!=null)
            Text(_news!['published_at'].toString().substring(0,10),
                style:TextStyle(fontSize:12,color:Colors.grey.shade500)),
          const Divider(height:24),
          Text(_news!['body']?.replaceAll(RegExp(r'<[^>]*>'), '') ?? '',
              style:const TextStyle(fontSize:15, height:1.8)),
        ]),
      ),
    ])),
  );
}
