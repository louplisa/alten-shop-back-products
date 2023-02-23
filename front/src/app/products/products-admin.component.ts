import { Component, OnInit } from '@angular/core';
import { Product, ProductPayload } from './product.class';
import {PRODUCT_TABLE_CONF} from './products-admin-table.conf';
import { ProductsService } from './products.service';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';
import { environment } from '../../environment/environment';
import { BaseTableLoader } from 'app/shared/ui/table/base-table-loader.class';
import { CrudItemOptions } from 'app/shared/utils/crud-item-options/crud-item-options.model';

@Component({
  selector: 'app-products-admin',
  templateUrl: './products-admin.component.html',
  styleUrls: ['./products-admin.component.scss']
})
export class ProductsAdminComponent extends BaseTableLoader implements OnInit {

  public payload$: BehaviorSubject<ProductPayload> = new BehaviorSubject<ProductPayload>({products:[],total:0});
  public conf: CrudItemOptions[] = PRODUCT_TABLE_CONF;
  public entity = Product;

  constructor(
    private readonly productsService: ProductsService,
    private http: HttpClient
  ) {
    super();
  }

  ngOnInit(): void {

    // Display data table
    this.http.get<any>(environment.api + '/products').subscribe(products => {
      this.payload$.next({products, total: products.length});
    });
  }

  public onDeleteProduct(ids: number[]): void {
    this.delete(ids[0]);
    this.ngOnInit();
  }

  public onSave(product: Product): void {
    product.id ? this.update(product) : this.create(product);
    this.ngOnInit();
  }

  private create(product: Product): void {
    this.http.post<any>(environment.api + '/products', product).subscribe();
    this.ngOnInit();
  }

  private update(product: Product): void {
    this.http.patch<any>(environment.api + '/products/' + product.id, product).subscribe(
    );
    this.ngOnInit();
  }

  private delete(id: number): void {
    this.http.delete<any>(environment.api + '/products/' + id).subscribe( );
    this.ngOnInit();
  }
}
