import { Component, OnInit } from '@angular/core';
import { Product } from '../../../products/product.class';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from '../../../../environment/environment';

@Component({
  selector: 'app-product-detail',
  templateUrl: './product-detail.component.html',
  styleUrls: ['./product-detail.component.scss']
})
export class ProductDetailComponent implements OnInit {

  product: Product|undefined;

  constructor(
      private http: HttpClient,
      private route: ActivatedRoute,
      private router: Router
  ) {

  }

  ngOnInit() {
    const productId: string|null = this.route.snapshot.paramMap.get('id');
    if (productId) {
      this.http.get<any>(environment.api + '/products/' + productId).subscribe(data => {
        this.product = data;
      });
    }
  }

  goToProductList() {
    this.router.navigate(['/products']);
  }

}
