from django.views import generic
# from django.shortcuts import render

class IndexView(generic.TemplateView):
    template_name = "index.html"