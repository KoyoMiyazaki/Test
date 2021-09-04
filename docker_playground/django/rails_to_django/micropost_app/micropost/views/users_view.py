from django.views import generic
# from django.shortcuts import render

class UsersView(generic.TemplateView):
    template_name = "users/new.html"
